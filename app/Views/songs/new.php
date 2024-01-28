<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <h2>Add song</h2>

    <form action="<?= base_url('songs'); ?>" method="post" autocomplete="off">

        <div class="d-flex">
            <h5 class="me-auto">Primary info</h5>
            <span class="h6 text-danger ms-1" style="font-size: smaller;">*<span class="text-black ms-1">required</span></span>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div>
                    <label for="titleInput" class="form-label" style="font-size: smaller;">TITLE<span class="text-danger ms-1">*</span></label>
                    <input type="text" class="form-control" name="title" id="titleInput" placeholder="Title" value="<?= set_value('title'); ?>">
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('title') : '' ?></span>
                </div>

                <label class="form-label mt-3" style="font-size: smaller;">ARTIST<span class="text-danger ms-1">*</span></label>
                <div class="col artist-field mt-0">
                    <select class="form-control" name="artist[]" id="artistSelect" multiple="multiple">
                    </select>
                </div>

                <label for="lyricsTextarea" class="form-label mt-3" style="font-size: smaller;">LYRICS<span class="text-danger ms-1">*</span></label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <textarea class="form-control" name="lyrics" id="lyricsTextarea" rows="20" value="<?= set_value('lyrics'); ?>"></textarea>
                <span class="text-danger"><?= isset($validation) ? $validation->getError('lyrics') : '' ?></span>
            </div>
            <div class="col-lg-6 fw-medium text-body-secondary">
                <h5 class="text-body fw-bold">First time transcribing?</h5>
                <p>
                    Here are a few helpful tips for getting started:
                </p>
                <ol>
                    <li>Type out all lyrics, even when a section of the song is repeated. Everything in the song should be transcribed, including adlibs, producer tags, etc. If you don't understand a lyric, use “[?]” instead.</li>
                    <li class="mt-2">Make sure to break transcriptions up into individual lines and use section headers above different song parts.</li>
                    <li class="mt-2">Only add a song to Lyrics Case if it has been officially released. Fan-made mashups, songs that leak pre-release, and songs that violate our community policy are not allowed on Lyrics Case.</li>
                </ol>
                <p>
                    To learn more about adding songs on Lyrics Case, check out the full guide here.
                </p>
            </div>
        </div>

        <h5 class="mt-3">Additional info</h5>

        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-auto">
                        <img src="https://images.squarespace-cdn.com/content/v1/5d2e2c5ef24531000113c2a4/1564770289250-9FPM7TAI5O56U9JQTPVO/album-placeholder.png" id="artworkPreview" class="img-thumbnail" width="100px" alt="">
                    </div>
                    <div class="col">
                        <label for="artworkInput" class="form-label" style="font-size: smaller;">ARTWORK</label>
                        <input type="url" class="form-control" name="artwork" id="artworkInput" placeholder="Enter a URL" value="<?= set_value('artwork'); ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <label for="dateInput" class="form-label" style="font-size: smaller;">RELEASE DATE</label>
                <input type="date" class="form-control" name="date" id="dateInput">
            </div>
        </div>

        <button type="submit" class="btn btn-primary rounded-pill fw-medium px-4">Submit</button>
    </form>
</div>

<!-- SELECT ARTISTS -->
<script>
    $(document).ready(function() {
        $('#artistSelect').select2({
            theme: 'bootstrap-5',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            tags: true,
            minimumInputLength: 2,
            ajax: {
                url: '<?= base_url('getartists'); ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            insertTag: function(data, tag) {
                data.push(tag);
            },
            templateResult: formatArtist,
            placeholder: "Search the primary artist"
        });

        function formatArtist(artist) {
            var $result = $(
                '<span>' +
                (artist.image ? '<img class="artist-image rounded-circle me-2" src="' + artist.image + '" width="30px" />' : '') +
                artist.text +
                '</span>'
            );

            return $result;
        }
    });
</script>

<!-- ACTUALIZAR PREVIEW DEL ARTWORK -->
<script>
    function updateArtworkPreview() {
        // Obtiene la URL del campo de entrada
        var artworkUrl = document.getElementById('artworkInput').value;

        // Actualiza la vista previa de la imagen
        var artworkPreview = document.getElementById('artworkPreview');
        artworkPreview.src = artworkUrl;
    }

    // Agrega el evento onpaste al campo de entrada
    document.getElementById('artworkInput').addEventListener('paste', function(event) {
        // Espera un breve momento para que el valor se actualice después de pegar
        setTimeout(updateArtworkPreview, 100);
    });
</script>

<?= $this->endSection(); ?>