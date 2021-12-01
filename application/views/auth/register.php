<div class="container justify-content-center">
    <div class="content">
        <div id="wizard" class="mt-3">
            <h2>KYC Verification</h2>
            <section>
                <form id="example-form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">NIK</label>
                        <input id="nik" name="nik" type="number" class="form-control" placeholder="Enter NIK" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Birth Date</label>
                        <input id="date" name="date" type="date" class="form-control" placeholder="Birth Date" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Your Picture</label>
                        <input class="form-control-file" type="file" name="file" id="formFile">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Picture Example:</label><br>
                        <img src="<?= base_url() ?>assets/image_example.jpg" alt="..." class="img-thumbnail" width="20%">
                    </div>




                    <button type="button" class="btn btn-success" id="validatebtn" onclick="validateKYC()">Validate</button>

                </form>
            </section>

            <h2>Data Fullfilment</h2>
            <section>
                <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac ligula elementum pellentesque.
                    In lobortis sollicitudin felis non eleifend. Morbi tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum
                    dictum, nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien a diam adipiscing consectetur.
                    In euismod augue ullamcorper leo dignissim quis elementum arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Vestibulum leo velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis iaculis nec, malesuada a diam.
                    Donec non pulvinar urna. Aliquam id velit lacus.</p>
            </section>




        </div>
    </div>
</div>

<script>
    var isValidated = false;

    function formRule() {
        var form = $("#example-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                nik: {
                    required: true,
                    minlength: 16
                },
                date: "required",
                file: {
                    required: true,
                }
            },
            messages: {
                "nik": "Please enter your NIK (Min: 16)",
                "date": "Please enter your Birth Date",
                "file": "Please upload your Picture",
            }
        });

        return form;
    }

    const validateKYC = () => {

        var formValidate = formRule();


        if (formValidate.valid()) {
            // $("#validatebtn").html(`<i class="fa fa-spinner fa-spin"></i> Loading`)
            // $("#validatebtn").prop('disabled', true)

            var formId = $("#example-form");
            var data = formId.serializeArray();

            var formdata = new FormData();
            jQuery.each($('#formFile')[0].files, function(i, file) {
                formdata.append('image', file);
            });

            formdata.append('nik', data[0].value)
            formdata.append('birthdate', data[1].value)

            $.ajax({
                url: "<?= base_url() ?>auth/kycverif",
                type: "POST",
                data: formdata,
                success: function(msg) {
                    alert(msg)
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }


        // isValidated = true;
        // your function code here
    };



    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function(event, currentIndex, newIndex) {
            var form = formRule();

            form.validate().settings.ignore = ":disabled,:hidden";
            console.log("isValidated", isValidated);

            if (!isValidated) {
                alert("You have to pass the KYC Verification Process.")
            }

            return isValidated;
        },
        onFinishing: function(event, currentIndex) {

            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            alert("Submitted!");
        }
    });
</script>