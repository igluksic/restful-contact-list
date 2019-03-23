<script type="application/javascript">
    $(document).ready(function() {
        var allContacts = {!! $searchData !!};

        $("#search").keyup(function(e) {
            $("#result_box").empty();
            var searchTerm=$("#search").val();
            if (searchTerm.length < 2) return;
            allContacts.forEach(function(entry) {
                    if (entry["searchString"].indexOf(searchTerm.toLowerCase()) != -1) {
                        $("#result_box").append('<a href="{{route('contact.edit')}}/' + entry["id"] + '">' + '<button type="button" class="btn btn-sm btn-outline-secondary">' + entry["first_name"] + ' ' + entry["last_name"] + ', ' + entry["email"] + '</button></a><br>');
                    }
                }
            )
        });
    });
</script>

<input type="text" id="search" name="search" placeholder="search...">
<div id="result_box"></div>