<div class="modal fade " id="exLargeModal{{ $loop->iteration }}" tabindex="-1" style="display: none;" aria-modal="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col mb-3">
                        <label for="nameExLarge" class="form-label">Name</label>
                        <input type="text"class="form-control" @readonly(true) @disabled(true)
                            value={{ $feedback->full_name }}>
                    </div>
                    <div class="col mb-3">
                        <label for="nameExLarge" class="form-label">Phone</label>
                        <input type="text"class="form-control" @readonly(true) @disabled(true)
                            value={{ $feedback->phone }}>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-0">
                        <label for="emailExLarge" class="form-label">Email</label>
                        <input type="text" class="form-control" value={{ $feedback->email }} @readonly(true)
                            @disabled(true)>
                    </div>
                </div>


                <div class="row">
                    <div class="col mb-0">
                        <div>
                            <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                            <textarea class="form-control" rows="3"@readonly(true) @disabled(true)>{{ $feedback->content }} </textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
