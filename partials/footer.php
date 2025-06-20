<footer class="site-footer">

    <a href="#top" class="smoothscroll scroll-top">
        <span class="icon-keyboard_arrow_up"></span>
    </a>

    <div class="container">
        <div class="row mb-5">
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <h3>Search Trending</h3>
                <ul class="list-unstyled">
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Graphic Design</a></li>
                    <li><a href="#">Web Developers</a></li>
                    <li><a href="#">Python</a></li>
                    <li><a href="#">HTML5</a></li>
                    <li><a href="#">CSS3</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <h3>Company</h3>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Career</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Resources</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <h3>Support</h3>
                <ul class="list-unstyled">
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <h3>Contact Us</h3>
                <div class="footer-social">
                    <a href="#"><span class="icon-facebook"></span></a>
                    <a href="#"><span class="icon-twitter"></span></a>
                    <a href="#"><span class="icon-instagram"></span></a>
                    <a href="#"><span class="icon-linkedin"></span></a>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-12">
                <p class="copyright"><small>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i class="icon-heart text-danger"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </small></p>
            </div>
        </div>
    </div>
</footer>

</div>

<!-- SCRIPTS -->
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.bundle.min.js"></script>
<script src="./js/isotope.pkgd.min.js"></script>
<script src="./js/stickyfill.min.js"></script>
<script src="./js/jquery.fancybox.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/jquery.waypoints.min.js"></script>
<script src="./js/quill.min.js"></script>
<script src="./js/jquery.animateNumber.min.js"></script>
<script src="./js/owl.carousel.min.js"></script>

<script src="./js/bootstrap-select.min.js"></script>

<script src="./js/custom.js"></script>

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

</body>

</html>