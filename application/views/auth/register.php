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
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Validate</button>
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
    // $(function() {
    //     $("#wizard").steps({
    //         headerTag: "h2",
    //         bodyTag: "section",
    //         transitionEffect: "slideLeft"
    //     });
    // });
    function formRule() {
        var form = $("#example-form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                nik: "required",
                date: "required"
            },
            messages: {
                "nik": "Please enter your NIK",
                "date": "Please enter your Birth Date",
            }
        });

        return form;
    }



    $("#wizard").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function(event, currentIndex, newIndex) {
            var form = formRule();

            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
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