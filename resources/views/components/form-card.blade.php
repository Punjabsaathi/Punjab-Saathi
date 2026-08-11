@props(['form'])

<div class="col-md-4 ftco-animate mb-4">
    <div class="card h-100 shadow-sm border-0" style="border-radius:10px;overflow:hidden;">
        @if($form->is_featured)
            <div class="text-white text-center py-1" style="background:#fc5e28;font-size:0.75rem;font-weight:600;">
                <span class="fa fa-star mr-1"></span> Featured
            </div>
        @endif
        <div class="card-body d-flex flex-column p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="mr-3 d-flex align-items-center justify-content-center rounded"
                     style="width:42px;height:42px;background:rgba(252,94,40,0.10);flex-shrink:0;">
                    <span class="fa fa-file-pdf-o" style="color:#fc5e28;font-size:1.2rem;"></span>
                </div>
                <div>
                    <small class="text-muted" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:.5px;">
                        {{ $form->category->name }}
                    </small>
                    <h6 class="mb-0" style="font-size:0.9rem;line-height:1.3;">
                        <a href="{{ route('forms.show', $form->slug) }}" class="text-dark" style="text-decoration:none;">
                            {{ \Illuminate\Support\Str::limit($form->title, 55) }}
                        </a>
                    </h6>
                </div>
            </div>
            @if($form->short_description)
                <p class="text-muted mb-3" style="font-size:0.82rem;line-height:1.5;">
                    {{ \Illuminate\Support\Str::limit($form->short_description, 90) }}
                </p>
            @endif
            <div class="mt-auto d-flex align-items-center justify-content-between pt-2" style="border-top:1px solid #f0f0f0;">
                <small class="text-muted">
                    <span class="fa fa-download mr-1"></span>{{ number_format($form->download_count) }}
                </small>
                <a href="{{ route('forms.download', $form->slug) }}"
                   class="btn btn-sm" style="background:#fc5e28;color:#fff;border-color:#fc5e28;font-size:0.78rem;">
                    <span class="fa fa-download mr-1"></span> Download
                </a>
            </div>
        </div>
    </div>
</div>