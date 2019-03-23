<script type="application/javascript">
    $(document).ready(function() {
        var add_button = $("#add_form_field");
        var addValue=$("#newElement").html();

        $(add_button).click(function(e) {
            e.preventDefault();
            $("#add_more").append(addValue); //add input box
        });
    });
</script>
<div id="newElement" style="display: none;">
    @include('contacts._phone_entry_blank')
</div>