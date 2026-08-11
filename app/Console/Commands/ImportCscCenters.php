<?php

namespace App\Console\Commands;

use App\Models\CscCenter;
use Illuminate\Console\Command;
use ZipArchive;
use XMLReader;

class ImportCscCenters extends Command
{
    protected $signature = 'csc:import {file : Filename or full path to the CSV or XLSX file}';
    protected $description = 'Import CSC centers from a CSV or Excel (.xlsx) file';

    public function handle(): int
    {
        $filePath = $this->argument('file');

        if (!str_starts_with($filePath, '/') && !str_contains($filePath, ':\\')) {
            $filePath = base_path($filePath);
        }

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return self::FAILURE;
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension === 'csv') return $this->importCsv($filePath);
        if (in_array($extension, ['xlsx', 'xls'])) return $this->importXlsx($filePath);

        $this->error("Unsupported file type: {$extension}. Use .xlsx or .csv");
        return self::FAILURE;
    }

    private function normalizeHeader(string $h): string
    {
        $h = strtolower(trim($h));
        $h = preg_replace('/[^a-z0-9]+/', '_', $h);
        $h = preg_replace('/_+/', '_', $h);
        return trim($h, '_');
    }

    private function validCoord(?string $value, float $min, float $max): ?string
    {
        if ($value === null || $value === '') return null;
        if (!is_numeric($value)) return null;
        $f = (float) $value;
        if ($f < $min || $f > $max) return null;
        return $value;
    }

    private function importXlsx(string $filePath): int
    {
        $this->info("Reading file: {$filePath}");

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            $this->error("Could not open xlsx file.");
            return self::FAILURE;
        }

        // Load shared strings
        $sharedStrings = [];
        $ssIndex = $zip->locateName('xl/sharedStrings.xml');
        if ($ssIndex !== false) {
            $ssXml    = $zip->getFromIndex($ssIndex);
            $ssReader = new XMLReader();
            $ssReader->xml($ssXml);
            $current = ''; $inT = false;
            while ($ssReader->read()) {
                if ($ssReader->nodeType === XMLReader::ELEMENT && $ssReader->localName === 't') { $inT = true; $current = ''; }
                if ($ssReader->nodeType === XMLReader::TEXT && $inT) { $current .= $ssReader->value; }
                if ($ssReader->nodeType === XMLReader::END_ELEMENT && $ssReader->localName === 't') { $inT = false; }
                if ($ssReader->nodeType === XMLReader::END_ELEMENT && $ssReader->localName === 'si') { $sharedStrings[] = $current; $current = ''; }
            }
            $ssReader->close();
            unset($ssXml);
        }

        $this->info("Loaded " . count($sharedStrings) . " shared strings.");

        $sheetIndex = $zip->locateName('xl/worksheets/sheet1.xml');
        if ($sheetIndex === false) {
            $this->error("Could not find sheet1.xml inside xlsx.");
            $zip->close();
            return self::FAILURE;
        }

        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        file_put_contents($tmpFile, $zip->getFromIndex($sheetIndex));
        $zip->close();

        $xml = new XMLReader();
        $xml->open($tmpFile);

        $headers      = null;
        $stats        = ['created' => 0, 'updated' => 0, 'skipped' => 0];
        $rowNum       = 0;
        $rowData      = [];
        $cellType     = '';
        $cellColIndex = 0;
        $inRow        = false;
        $inV          = false;
        $inIs         = false;
        $inIsT        = false;
        $cellValue    = '';
        $isValue      = '';

        while ($xml->read()) {

            if ($xml->nodeType === XMLReader::ELEMENT) {
                if ($xml->localName === 'row') {
                    $inRow = true; $rowData = [];
                }
                if ($xml->localName === 'c' && $inRow) {
                    $ref          = $xml->getAttribute('r') ?? '';
                    $cellType     = $xml->getAttribute('t') ?? '';
                    $cellValue    = '';
                    $isValue      = '';
                    $cellColIndex = $this->colLetterToIndex($ref);
                    $inV          = false;
                    $inIs         = false;
                    $inIsT        = false;
                }
                if ($xml->localName === 'v' && $inRow && !$inIs) {
                    $inV = true; $cellValue = '';
                }
                if ($xml->localName === 'is' && $inRow) {
                    $inIs = true; $isValue = '';
                }
                if ($xml->localName === 't' && $inIs && $inRow) {
                    $inIsT = true;
                }
            }

            if ($xml->nodeType === XMLReader::TEXT) {
                if ($inV)   { $cellValue .= $xml->value; }
                if ($inIsT) { $isValue   .= $xml->value; }
            }

            if ($xml->nodeType === XMLReader::END_ELEMENT) {

                if ($xml->localName === 'v' && $inV && $inRow) {
                    $inV = false;
                    $rowData[$cellColIndex] = $cellType === 's'
                        ? ($sharedStrings[(int) $cellValue] ?? '')
                        : $cellValue;
                }

                if ($xml->localName === 't' && $inIsT) {
                    $inIsT = false;
                }

                if ($xml->localName === 'is' && $inIs && $inRow) {
                    $inIs = false;
                    $rowData[$cellColIndex] = $isValue;
                }

                if ($xml->localName === 'row' && $inRow) {
                    $rowNum++;
                    $inRow = false;

                    $flat = [];
                    if (!empty($rowData)) {
                        $maxCol = max(array_keys($rowData));
                        for ($i = 0; $i <= $maxCol; $i++) { $flat[] = $rowData[$i] ?? ''; }
                    }

                    if ($headers === null) {
                        $headers = array_map(fn($h) => $this->normalizeHeader((string) $h), $flat);
                        $this->info("Headers: " . implode(', ', $headers));
                        continue;
                    }

                    if (empty(array_filter($flat, fn($v) => trim((string)$v) !== ''))) continue;

                    while (count($flat) < count($headers)) { $flat[] = ''; }
                    $data = array_combine($headers, array_slice($flat, 0, count($headers)));

                    $this->saveRow($data, $stats);

                    if ($rowNum % 500 === 0) {
                        $this->line("Processed {$rowNum} rows... (created:{$stats['created']} updated:{$stats['updated']} skipped:{$stats['skipped']})");
                    }
                }
            }
        }

        $xml->close();
        unlink($tmpFile);
        $this->printStats($stats);
        return self::SUCCESS;
    }

    private function saveRow(array $data, array &$stats): void
    {
        $rawMobile = $data['mobile_phone'] ?? $data['mobile'] ?? $data['mobile_number'] ?? $data['phone'] ?? null;
        $mobile    = preg_replace('/\D/', '', (string) $rawMobile);
        $mobile    = strlen($mobile) === 10 ? $mobile : null;

        $registeredOn = null;
        $rawDate = trim((string)($data['registered_on'] ?? ''));
        if ($rawDate !== '') {
            $ts = strtotime($rawDate);
            if ($ts !== false) $registeredOn = date('Y-m-d', $ts);
        }

        $payload = [
            'csc_id'        => $this->val($data, 'csc_id'),
            'vle_name'      => $this->val($data, 'vle_operator', 'vle_name', 'vle', 'name', 'operator'),
            'kiosk_name'    => $this->val($data, 'kiosk_center', 'kiosk_name', 'kiosk'),
            'mobile'        => $mobile,
            'email'         => $this->val($data, 'email', 'email_id'),
            'address'       => $this->val($data, 'address', 'full_address'),
            'sub_district'  => $this->val($data, 'sub_district', 'tehsil', 'block'),
            'district'      => $this->val($data, 'district'),
            'state'         => $this->val($data, 'state') ?? 'Punjab',
            'pincode'       => $this->val($data, 'pincode', 'pin_code', 'pin'),
            'latitude'      => $this->validCoord($this->val($data, 'latitude'), -90, 90),
            'longitude'     => $this->validCoord($this->val($data, 'longitude'), -180, 180),
            'registered_on' => $registeredOn,
            'source'        => $this->val($data, 'source') ?? 'excel-import',        ];

        try {
            $existing = null;

            if ($mobile) {
                $existing = CscCenter::where('mobile', $mobile)->first();
            }
            if (!$existing && !empty($payload['csc_id'])) {
                $existing = CscCenter::where('csc_id', $payload['csc_id'])->first();
            }

            if ($existing) {
                $update = array_filter($payload, fn($v) => $v !== null && $v !== '');
                unset($update['is_verified'], $update['is_active'], $update['notes']);
                $existing->update($update);
                $stats['updated']++;
            } else {
                CscCenter::create($payload);
                $stats['created']++;
            }
        } catch (\Exception $e) {
            $stats['skipped']++;
            $this->warn("Save failed: " . $e->getMessage());
        }
    }

    private function val(array $data, string ...$keys): ?string
    {
        foreach ($keys as $key) {
            $v = trim((string)($data[$key] ?? ''));
            if ($v !== '') return $v;
        }
        return null;
    }

    private function colLetterToIndex(string $cellRef): int
    {
        preg_match('/^([A-Z]+)/i', $cellRef, $m);
        $letters = strtoupper($m[1] ?? 'A');
        $index   = 0;
        for ($i = 0; $i < strlen($letters); $i++) {
            $index = $index * 26 + (ord($letters[$i]) - 64);
        }
        return $index - 1;
    }

    private function importCsv(string $filePath): int
    {
        $handle  = fopen($filePath, 'r');
        $headers = null;
        $stats   = ['created' => 0, 'updated' => 0, 'skipped' => 0];

        while (($row = fgetcsv($handle)) !== false) {
            if ($headers === null) {
                $headers = array_map(fn($h) => $this->normalizeHeader($h), $row);
                $this->info("Headers: " . implode(', ', $headers));
                continue;
            }
            if (count($row) !== count($headers)) continue;
            $data = array_combine($headers, $row);
            $this->saveRow($data, $stats);
        }

        fclose($handle);
        $this->printStats($stats);
        return self::SUCCESS;
    }

    private function printStats(array $stats): void
    {
        $this->newLine();
        $this->info('Import complete:');
        $this->line("  Created : {$stats['created']}");
        $this->line("  Updated : {$stats['updated']}");
        $this->line("  Skipped : {$stats['skipped']}");
    }
}