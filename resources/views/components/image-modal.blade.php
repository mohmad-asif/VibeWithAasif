<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-3 shadow-lg border-0">

      <div class="modal-header bg-gradient text-white py-3 px-4" style="background: linear-gradient(90deg, #6366f1, #a855f7);">
        <h5 class="modal-title fw-bold">Manage Images</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">

        <div class="mb-4">
          <label for="imageInput" class="form-label fw-semibold">Upload New Images</label>
          <input type="file" id="imageInput" multiple class="form-control">
        </div>

        <div id="imagePreview" class="row g-3">
          @isset($existingImages)
            @foreach($existingImages as $img)
              <div class="col-6 col-sm-4 col-md-3 text-center existing-image" data-id="{{ $img->id }}">
                <div class="card h-100 shadow-sm position-relative border-0">
                  <img src="{{ asset('storage/'.$img->path) }}"
                       class="card-img-top rounded"
                       style="height: 120px; object-fit: cover;">

                  <button type="button"
                          class="btn btn-sm btn-danger rounded-circle position-absolute top-0 end-0 m-1 remove-existing"
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

      <div class="modal-footer border-0 p-3">
        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary px-4" id="saveImagesBtn">Save</button>
      </div>
    </div>
  </div>
</div>

<input type="file" id="hiddenImageInput" name="images[]" multiple hidden>
