<div class="container justify-content-center">
    <div class="content">
        <div id="wizard" class="mt-3">
            <h2>KYC Verification</h2>
            <section>
                <form id="example-form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">NIM</label>
                        <input id="nim" name="nim" type="number" class="form-control" placeholder="Enter NIM" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your data with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Full Name</label>
                        <input id="fullname" name="fullname" type="text" class="form-control" placeholder="fullname" required>
                    </div>

                    <button type="button" class="btn btn-success" id="validatebtn" onclick="validateKYC()">Validate</button>

                </form>
            </section>

            <h2>Data Fullfilment</h2>
            <section>
                <form id="form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </form>
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
            
            },
            messages: {
                "nik": "Please enter your NIK (Min: 16)",
                "date": "Please enter your Birth Date",
            }
        });

        return form;
    }

    function formDataRule() {
        var form = $("#form-data");
        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            rules: {
                name: {
                    required: true,
                },
                email: "required",
                password: {
                    required: true,
                }
            },
            messages: {
                "name": "Please enter your Name",
                "email": "Please enter your Email",
                "password": "Please enter your Password",
            }
        });

        return form;
    }

    const validateKYC = () => {

        var formValidate = formRule();


        if (formValidate.valid()) {
            $("#validatebtn").html(`<i class="fa fa-spinner fa-spin"></i> Loading`)
            $("#validatebtn").prop('disabled', true)

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
                    // const response = JSON.parse(msg)
                    // console.log(response)
                    // if (response.data) {
                    //     isValidated = true;
                    //     $("#validatebtn").html(`Congrats! you're validated`)
                    //     $("#validatebtn").prop('disabled', true)
                    // } else {
                    //     $("#validatebtn").html(`Validated`)
                    //     $("#validatebtn").prop('disabled', false)
                    // }
                    // alert(response.message)
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

    function registersend() {
        var form = $("#form-data");
        var data = form.serializeArray();
        var nik = $("#nik").val()
        var formdata = new FormData();

        formdata.append('name', data[0].value)
        formdata.append('email', data[1].value)
        formdata.append('password', data[2].value)
        formdata.append('nik', nik)


        $.ajax({
            url: "<?= base_url() ?>auth/registerprocess",
            type: "POST",
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            success: function(msg) {
                console.log(msg)
            },
        });
    }



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
            var form = formDataRule();
            form.validate().settings.ignore = ":disabled";
            registersend();

            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            alert("Succesfuly Register!");
            window.location.replace("<?=base_url()?>auth/login");
        }
    });
</script>