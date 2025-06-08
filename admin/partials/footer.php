</div>
</div>
</body>
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugin/chartist/chartist.min.js"></script>
<script src="assets/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<!-- <script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script> -->
<script src="assets/js/plugin/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/js/plugin/jquery-mapael/maps/world_countries.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/js/ready.min.js"></script>
<script src="assets/js/demo.js"></script>
<script src="assets/js/quill.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
const quill = new Quill('#editor-1', {
    theme: 'snow'
});
const quill2 = new Quill('#editor-2', {
    theme: 'snow'
});

document.querySelector('form').addEventListener('submit', function(e) {
    document.getElementById('job_description_input').value = quill.root.innerHTML;
    document.getElementById('company_description_input').value = quill2.root.innerHTML;
});

setTimeout(() => {
    const alertNode = document.querySelector('.alert');
    if (alertNode) {
        // Bootstrap 5 uses Alert class
        bootstrap.Alert.getOrCreateInstance(alertNode).close();
    }
}, 4000);
</script>


</html>