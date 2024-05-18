<a href="#" class="has_action btn btn-icon btn-light-warning me-5" data-type="edit"
   data-action="{{ route('album.edit', $album->id) }}" data-album-id="{{ $albumId }}">
   <i class="fa-solid fa-pen-to-square"></i>
</a>

<button type="button" class="btn btn-icon btn-light-danger me-5 open-modal-btn" data-bs-toggle="modal" data-bs-target="#kt_modal_1" data-album-id="{{ $album->id }}">
    <i class="fa-solid fa-trash"></i>
</button>


<!-- Modal structure -->
<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modal title</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <p>Choose a target album to move images:</p>
                <select id="targetAlbumSelect" class="form-control">
                    <!-- Options will be populated here -->
                </select>
                <input type="hidden" id="modalAlbumID" value="{{$album->id}}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="deleteWithImagesBtn" data-album-id="{{ $album->id }}">Delete with Images</button>
                <button type="button" class="btn btn-primary" id="moveImagesBtn" data-album-id="{{ $album->id }}">Move Images</button>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    console.log('Custom JS ready');
    
    $(document).on('click', '.open-modal-btn', function() {
        const albumId = $(this).data('album-id');
        $('#modalAlbumID').val(albumId); 
        console.log('Album ID:', albumId);
        
        fetch('/api/albums')
            .then(response => response.json())
            .then(data => {
                console.log('Albums fetched:', data);
                populateAlbumSelect(data);
            })
        .catch(error => console.error('Error fetching albums:', error));
    });

    function populateAlbumSelect(albums) {
        const select = document.getElementById('targetAlbumSelect');
        select.innerHTML = '';
        albums.forEach(album => {
            const option = document.createElement('option');
            option.value = album.id;
            option.textContent = album.name;
            select.appendChild(option);
        });
    }

    $(document).on('click', '#deleteWithImagesBtn', function(event) {
        event.preventDefault();
        const albumId = $(this).data('album-id');
        console.log('Delete album ID:', albumId);
        
        $.ajax({
            url: `/albums/${albumId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Response from server:', data);
                if (data.has_images) {
                    $('#kt_modal_1').modal('show');
                    $('#deleteWithImagesBtn').off('click').on('click', function() {
                        deleteWithImages(albumId);
                    });
                    $('#moveImagesBtn').off('click').on('click', function() {
                        const targetAlbumId = $('#targetAlbumSelect').val();
                        moveImages(albumId, targetAlbumId);
                    });
                } else {
                    window.location.reload();
                }
            },
            error: function(error) {
                console.error('Error during deletion:', error);
            }
        });
    });

    $(document).on('click', '#moveImagesBtn', function(event) {
        event.preventDefault();
        const albumId = $('#modalAlbumID').val();
        const targetAlbumId = $('#targetAlbumSelect').val();
        console.log(`Moving images from album ID: ${albumId} to album ID: ${targetAlbumId}`);
        
        $.ajax({
            url: `/albums/${albumId}/move-images`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({ target_album_id: targetAlbumId }),
            success: function(response) {
                console.log('Images moved, response:', response);
                window.location.reload();
            },
            error: function(error) {
                console.error('Error during move images:', error);
            }
        });
    });
});

</script>