<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-3xl shadow-2xl border-0 overflow-hidden">

      <div class="modal-header text-white py-4 px-6" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);">
        <div class="flex items-center gap-2">
            <i class="fas fa-images text-lg"></i>
            <h5 class="modal-title font-bold font-heading m-0 text-white">Manage & Upload Images</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-6">

        <div class="mb-5 p-5 bg-purple-50/50 rounded-2xl border-2 border-dashed border-purple-200 text-center">
          <label for="imageInput" class="form-label font-bold text-slate-800 block mb-2 cursor-pointer">
            <i class="fas fa-cloud-arrow-up text-2xl text-purple-600 mb-1 block"></i>
            Choose Images from your Computer
          </label>
          <input type="file" id="imageInput" multiple accept="image/*" class="form-control rounded-xl border-slate-300">
          <p class="text-xs text-slate-500 mt-2">Supports JPG, PNG, WEBP files.</p>
        </div>

        <div>
          <h6 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Selected & Current Images</h6>
          <div id="imagePreview" class="row g-3">
            @isset($existingImages)
              @foreach($existingImages as $img)
                <div class="col-6 col-sm-4 col-md-3 text-center existing-image" data-id="{{ $img->id }}">
                  <div class="card h-100 shadow-sm position-relative border-0 rounded-2xl overflow-hidden bg-slate-100">
                    <img src="{{ asset('storage/'.$img->path) }}"
                         class="card-img-top"
                         style="height: 120px; object-fit: cover;"
                         onerror="this.onerror=null; this.src='{{ asset('images/headers/header1.jpg') }}';">

                    <button type="button"
                            class="btn btn-sm btn-danger rounded-circle position-absolute top-0 end-0 m-1.5 remove-existing p-0 flex items-center justify-center leading-none"
                            style="width: 24px; height: 24px;"
                            title="Remove">
                      &times;
                    </button>

                    <input type="hidden" name="keep_images[]" value="{{ $img->id }}">
                  </div>
                </div>
              @endforeach
            @endisset
          </div>
        </div>
      </div>

      <div class="modal-footer border-t border-slate-100 bg-slate-50 px-6 py-4 flex gap-2">
        <button type="button" class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-sm transition" data-bs-dismiss="modal">Close</button>
        <button type="button" class="gradient-btn px-6 py-2.5 rounded-xl text-white font-bold text-sm shadow-md transition" id="saveImagesBtn">Done</button>
      </div>
    </div>
  </div>
</div>

<input type="file" id="hiddenImageInput" name="images[]" multiple hidden>
