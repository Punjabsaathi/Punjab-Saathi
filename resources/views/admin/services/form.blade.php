<div class="row">

    {{-- Title --}}
    <div class="col-md-6 mb-3">
        <label>Title</label>
        <input type="text"
               name="title"
               class="form-control"
               value="{{ old('title', $service->title ?? '') }}">
    </div>

    {{-- Slug --}}
    <div class="col-md-6 mb-3">
        <label>Slug</label>
        <input type="text"
               name="slug"
               class="form-control"
               value="{{ old('slug', $service->slug ?? '') }}">
    </div>

    {{-- Tag --}}
    <div class="col-md-6 mb-3">
        <label>Tag</label>
        <input type="text"
               name="tag"
               class="form-control"
               value="{{ old('tag', $service->tag ?? '') }}">
    </div>

    {{-- Category --}}
    <div class="col-md-6 mb-3">
        <label>Category</label>
        <input type="text"
               name="category"
               class="form-control"
               value="{{ old('category', $service->category ?? '') }}">
    </div>

    {{-- Icon --}}
    <div class="col-md-6 mb-3">
        <label>FontAwesome Icon</label>
        <input type="text"
               name="icon"
               class="form-control"
               placeholder="fa-id-card"
               value="{{ old('icon', $service->icon ?? '') }}">
    </div>

    {{-- Color --}}
    <div class="col-md-6 mb-3">
        <label>Color</label>
        <input type="color"
               name="color"
               class="form-control form-control-color"
               value="{{ old('color', $service->color ?? '#fc5e28') }}">
    </div>

    {{-- Short Description --}}
    <div class="col-md-12 mb-3">
        <label>Short Description</label>

        <textarea name="short_desc"
                  rows="3"
                  class="form-control">{{ old('short_desc', $service->short_desc ?? '') }}</textarea>
    </div>

    {{-- Overview --}}
    <div class="col-md-12 mb-3">
        <label>Overview</label>

        <textarea name="overview"
                  rows="8"
                  class="form-control">{{ old('overview', $service->overview ?? '') }}</textarea>
    </div>

    {{-- Processing Time --}}
    <div class="col-md-4 mb-3">
        <label>Processing Time</label>
        <input type="text"
               name="processing_time"
               class="form-control"
               value="{{ old('processing_time', $service->processing_time ?? '') }}">
    </div>

    {{-- Fee Range --}}
    <div class="col-md-4 mb-3">
        <label>Fee Range</label>
        <input type="text"
               name="fee_range"
               class="form-control"
               value="{{ old('fee_range', $service->fee_range ?? '') }}">
    </div>

    {{-- Sort Order --}}
    <div class="col-md-4 mb-3">
        <label>Sort Order</label>
        <input type="number"
               name="sort_order"
               class="form-control"
               value="{{ old('sort_order', $service->sort_order ?? 0) }}">
    </div>

    {{-- Fee Note --}}
    <div class="col-md-12 mb-3">
        <label>Fee Note</label>

        <textarea name="fee_note"
                  rows="3"
                  class="form-control">{{ old('fee_note', $service->fee_note ?? '') }}</textarea>
    </div>

    {{-- Eligibility --}}
    <div class="col-md-12 mb-3">
        <label>Eligibility</label>

        <textarea name="eligibility"
                  rows="5"
                  class="form-control">{{ old('eligibility', $service->eligibility ?? '') }}</textarea>
    </div>

    {{-- SEO Section --}}
    <div class="col-md-12">
        <hr>
        <h5 class="mb-3">SEO Settings</h5>
    </div>

    {{-- Meta Title --}}
    <div class="col-md-12 mb-3">
        <label>Meta Title</label>
        <input type="text"
               name="meta_title"
               class="form-control"
               value="{{ old('meta_title', $service->meta_title ?? '') }}">
    </div>

    {{-- Meta Description --}}
    <div class="col-md-12 mb-3">
        <label>Meta Description</label>

        <textarea name="meta_description"
                  rows="3"
                  class="form-control">{{ old('meta_description', $service->meta_description ?? '') }}</textarea>
    </div>

    {{-- Meta Keywords --}}
    <div class="col-md-12 mb-3">
        <label>Meta Keywords</label>

        <textarea name="meta_keywords"
                  rows="2"
                  class="form-control">{{ old('meta_keywords', $service->meta_keywords ?? '') }}</textarea>
    </div>

    {{-- OG Image --}}
    <div class="col-md-12 mb-3">
        <label>OG Image</label>

        <input type="file"
               name="og_image"
               class="form-control">

        @if(!empty($service->og_image))
            <img src="{{ asset('storage/'.$service->og_image) }}"
                 class="mt-2 rounded"
                 width="120">
        @endif
    </div>

    {{-- Active --}}
    <div class="col-md-3 mb-3">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   name="is_active"
                   value="1"
                   {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>

            <label class="form-check-label">
                Active
            </label>
        </div>
    </div>

    {{-- Popular --}}
    <div class="col-md-3 mb-3">
        <div class="form-check">
            <input type="checkbox"
                   class="form-check-input"
                   name="is_popular"
                   value="1"
                   {{ old('is_popular', $service->is_popular ?? false) ? 'checked' : '' }}>

            <label class="form-check-label">
                Popular
            </label>
        </div>
    </div>

</div>

{{-- DOCUMENTS SECTION --}}
<hr class="my-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Required Documents</h5>

    <button type="button"
            class="btn btn-primary btn-sm"
            onclick="addDocument()">

        Add Document

    </button>
</div>

<div id="documents-wrapper">

    @if(isset($service) && $service->documents)

        @foreach($service->documents as $i => $doc)

        <div class="card p-3 mb-3">

            <div class="row">

                <div class="col-md-4">
                    <input type="text"
                           name="documents[{{ $i }}][label]"
                           class="form-control"
                           value="{{ $doc->label }}"
                           placeholder="Document Name">
                </div>

                <div class="col-md-4">
                    <input type="text"
                           name="documents[{{ $i }}][note]"
                           class="form-control"
                           value="{{ $doc->note }}"
                           placeholder="Note">
                </div>

                <div class="col-md-2">
                    <select name="documents[{{ $i }}][is_mandatory]"
                            class="form-select">

                        <option value="1" {{ $doc->is_mandatory ? 'selected' : '' }}>
                            Mandatory
                        </option>

                        <option value="0" {{ !$doc->is_mandatory ? 'selected' : '' }}>
                            Optional
                        </option>

                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger w-100"
                            onclick="this.parentElement.parentElement.parentElement.remove()">

                        Remove

                    </button>
                </div>

            </div>

        </div>

        @endforeach

    @endif

</div>

{{-- FAQ SECTION --}}
<hr class="my-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>FAQs</h5>

    <button type="button"
            class="btn btn-primary btn-sm"
            onclick="addFaq()">

        Add FAQ

    </button>
</div>

<div id="faq-wrapper">

    @if(isset($service) && $service->faqs)

        @foreach($service->faqs as $i => $faq)

        <div class="card p-3 mb-3">

            <div class="mb-3">
                <input type="text"
                       name="faqs[{{ $i }}][question]"
                       class="form-control"
                       value="{{ $faq->question }}"
                       placeholder="Question">
            </div>

            <div class="mb-3">
                <textarea name="faqs[{{ $i }}][answer]"
                          class="form-control"
                          rows="4"
                          placeholder="Answer">{{ $faq->answer }}</textarea>
            </div>

            <button type="button"
                    class="btn btn-danger"
                    onclick="this.parentElement.remove()">

                Remove FAQ

            </button>

        </div>

        @endforeach

    @endif

</div>

@push('scripts')

<script>

let docIndex = {{ isset($service) ? $service->documents->count() : 0 }};
let faqIndex = {{ isset($service) ? $service->faqs->count() : 0 }};

function addDocument()
{
    let html = `
    <div class="card p-3 mb-3">

        <div class="row">

            <div class="col-md-4">
                <input type="text"
                       name="documents[\${docIndex}][label]"
                       class="form-control"
                       placeholder="Document Name">
            </div>

            <div class="col-md-4">
                <input type="text"
                       name="documents[\${docIndex}][note]"
                       class="form-control"
                       placeholder="Note">
            </div>

            <div class="col-md-2">
                <select name="documents[\${docIndex}][is_mandatory]"
                        class="form-select">

                    <option value="1">Mandatory</option>
                    <option value="0">Optional</option>

                </select>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger w-100"
                        onclick="this.parentElement.parentElement.parentElement.remove()">

                    Remove

                </button>
            </div>

        </div>

    </div>
    `;

    document.getElementById('documents-wrapper')
        .insertAdjacentHTML('beforeend', html);

    docIndex++;
}

function addFaq()
{
    let html = `
    <div class="card p-3 mb-3">

        <div class="mb-3">
            <input type="text"
                   name="faqs[\${faqIndex}][question]"
                   class="form-control"
                   placeholder="Question">
        </div>

        <div class="mb-3">
            <textarea name="faqs[\${faqIndex}][answer]"
                      class="form-control"
                      rows="4"
                      placeholder="Answer"></textarea>
        </div>

        <button type="button"
                class="btn btn-danger"
                onclick="this.parentElement.remove()">

            Remove FAQ

        </button>

    </div>
    `;

    document.getElementById('faq-wrapper')
        .insertAdjacentHTML('beforeend', html);

    faqIndex++;
}

</script>

@endpush