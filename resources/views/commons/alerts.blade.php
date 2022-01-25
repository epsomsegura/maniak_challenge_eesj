@if($errors->any())
@php
$errData = '<ul class="text-justify">';
foreach($errors->all() as $e){ $errData.='<li class="text-justify">'.str_replace("'","",$e).'</li>'; }
$errData .= '</ul>';
@endphp
<script>
    Swal.fire({
        title: "Alert",
        text: "Here are some errors",
        html: '{!! $errData !!}',
        icon: "error",
        confirmButtonText: "Close",
        confirmButtonColor: "#dc3545"
    });
</script>

@endif

@if(session('status'))
<script>
    Swal.fire({
        title: "Ok",
        text: '{!! session("status") !!}',
        icon: "success",
        confirmButtonText: "Close",
        confirmButtonColor: "#007bff"
    });
</script>
@endif
