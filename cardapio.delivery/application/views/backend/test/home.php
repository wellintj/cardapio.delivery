<div class="upload">
    <div class="row">
        <div class="col-md-4">
            <label id="inputImage">
                Upload
            </label>
        </div>
    </div>
</div>

<img src="" id="imgPreview" class="imgPreview" alt="">


<div id="imageCropper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="cropingArea">

                    <div class="previewImg">
                        
                    </div>

                    <input type="file" id="upImg">
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:;" id="cropBtn" class="btn btn-secondary ">crop</a>
            </div>
        </div>
    </div>
</div>

<style>
    #cropImg {
        display: block;
        max-width: 100%;

    }

    .cropingArea{
        height: 400px;
        width: 100%;
        position: relative;
    }
    .previewImg{
        width: 100%;
        height: 100%;
    }
</style>


<script>
    $(document).ready(function() {



        $(document).on('click', '#inputImage', function() {
            $('#imageCropper').modal('show');
        });


        // Handle file input change event
        $('#upImg').on('change', function(e) {

            var input = e.target;
            var reader = new FileReader();



            reader.onload = function() {

                // Display the image in the modal
               
                $('#imageCropper').modal('show');
                 $('.previewImg').html('<img src="' + reader.result + '" id="cropImg" alt="Croppable Image" />');
                crop('cropImg')

            };
            // console.log(input.files[0]);
            // Read the selected file as a data URL
            reader.readAsDataURL(input.files[0]);



        });

        function crop(ids) {
            var cropperElement = $('#' + ids);
            // Initialize Cropper.js on the displayed image


            if (cropperElement.length > 0) {
                var cropper = new Cropper(cropperElement[0], {
                    aspectRatio: 16/9, // Set the aspect ratio (width/height)
                });


                console.log(cropper);
                // Handle crop button click
                $('#cropBtn').on('click', function() {
                    // Get the cropped canvas
                    var croppedCanvas = cropper.getCroppedCanvas();

                    // Convert the canvas to a data URL
                    var croppedDataUrl = croppedCanvas.toDataURL('image/jpeg');

                    $('.imgPreview').attr('src', croppedDataUrl);


                    // $('.imgPreviewDiv').slideUp();
                    // $('.imgPreview').slideDown().removeClass('opacity_0');
                    // Perform image upload (you can use AJAX to send the data to the server)
                    //    console.log('Cropped Image Data:', croppedDataUrl);

                    // Close the modal
                    $('#imageCropper').modal('hide');
                });
            }
        }
    });



</script>