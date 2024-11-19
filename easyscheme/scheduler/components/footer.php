 <!-- AlpineJS -->
 <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var currentPath = window.location.pathname;
        $('nav a').each(function() {
            var linkPath = "/"+$(this).attr('href');
            if (currentPath === linkPath) {
                $(this).addClass('active-nav-link');
                $(this).removeClass('opacity-75');
            }
        });
    });
</script>