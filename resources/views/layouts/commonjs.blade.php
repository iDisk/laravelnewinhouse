<script>
    var resizefunc = [];
</script>
<!-- jQuery  -->
<script src="{{ url('assets/js/jquery.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assets/js/metisMenu.min.js') }}"></script>
<script src="{{ url('assets/js/waves.js') }}"></script>
<script src="{{ url('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ url('assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<!-- Counter js  -->
<script src="{{ url('assets/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ url('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
<!--C3 Chart-->
<script src="{{ url('assets/plugins/d3/d3.min.js') }}"></script>
<script src="{{ url('assets/plugins/c3/c3.min.js') }}"></script>
<!-- Dashboard init -->
<script src="{{ url('assets/pages/jquery.dashboard.js') }}"></script>
<!-- Sweet-Alert  -->
<script src="{{ url('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

<!-- Parsley -->
<script src="{{ url('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<!-- App js -->
<script src="{{ url('assets/js/jquery.core.js') }}"></script>
<script src="{{ url('assets/js/jquery.app.js') }}"></script>
<script>
    // Custom validator of parsley for multiple of a number
    window.Parsley.addValidator('multipleOf', {
        requirementType: 'integer',
        validateNumber: function(value, requirement) {
            return 0 === value % requirement && value != 0;
        },
    });
    // Custom validator of parsley for file formats
    window.Parsley
        .addValidator('filemaxmegabytes', {
            requirementType: 'string',
            validateString: function (value, requirement, parsleyInstance) {
                // if (!app.utils.formDataSuppoerted) {
                //     return true;
                // }
                var files = parsleyInstance.$element[0].files;
                var maxBytes = requirement * 1048576;
                if (files.length == 0) {
                    return true;
                }
                // Check the max file sizes of all the attachments
                var returnValue = true;
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > maxBytes) {
                        returnValue = false;
                        break;
                    }
                }
                return returnValue;
            },
        })
        .addValidator('filemimetypes', {
            requirementType: 'string',
            validateString: function (value, requirement, parsleyInstance) {
                // if (!app.utils.formDataSuppoerted) {
                //     return true;
                // }
                var files = parsleyInstance.$element[0].files;
                if (files.length == 0) {
                    return true;
                }
                var allowedMimeTypes = requirement.replace(/\s/g, "").split(',');
                // Check the file types of all the attachments
                var returnValue = true;
                for (var i = 0; i < files.length; i++) {
                    if (allowedMimeTypes.indexOf(files[i].type) === -1) {
                        returnValue = false;
                    }
                }
                return returnValue;
            },
        })
        .addValidator('maxfiles', {
            validate: function(value, requirement, parsleyInstance) {
                var files = parsleyInstance.$element[0].files;
                return files.length <= requirement;
            }
        })
        .addValidator('chars', {
            validate: function(value, requirement, parsleyInstance) {
                var letters = /^[A-Za-z .]+$/;
                // Remove accents from the letters
                value = value.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                if (value.match(letters)) {
                    return true;
                }
                return false;
            }
        })
        .addValidator('tel', {
            validate: function(value, requirement, parsleyInstance) {
                var tel = /^([+]?\d{1,2}[.-\s]?)?(\d{1,3}[.-]?){2}\d{1,4}$/;
                if (value.match(tel)) {
                    return true;
                }
                return false;
            }
        });
</script>