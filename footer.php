<!-- DISPLAYS OF ALERTS AND ERRORS IF THERE ARE -->
<?php
if(isset($_SESSION['alert'])) : ?>
    <div class="fixed-bottom w-50 alert alert-<?= $_SESSION['alert']['type'] ?> rounded-0 shadow mx-auto mt-1 fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="alert-heading"><?= $_SESSION['alert']['title'] ?></h4>
        <p class="mb-0"><?= $_SESSION['alert']['message'] ?></p>
    </div>
<?php endif; ?>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
<script>
    setTimeout( () => {
        $('.alert').alert('close');
    }, 3000);
</script>
</body>
</html>

<?php
// Deleting sessions when the page is displayed
unset($_SESSION['alert']);
unset($_SESSION['post']);
unset($_SESSION['errors']);
?>