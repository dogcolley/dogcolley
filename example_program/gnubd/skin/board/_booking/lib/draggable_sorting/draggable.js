<?php ?>
<script>
	

$(function() {
	$('#sorting_mode').click(function() {
		alert("<?=$board_skin_url?>");
		//순서바꾸기
		if ($(this).val() == "순서바꾸기") {

			$(this).val("완료");
			
		    $( "#sortable" ).sortable({
			    start: function(event, ui) {
			        // Create a temporary attribute on the element with the old index
			        $(this).attr('data-currentindex', ui.item.index());
			    },
			    update: function(event, ui) {
			    	var id = ui.item;
			        let current_position = $(this).attr('data-currentindex');
			        let desired_position = ui.item.index();
			        
			        $.ajax({
		                url: "<?=$board_skin_url?>/lib/draggable_sorting/draggable.php?ver=20201008",
		                type: "POST",
		                data: {
		                    "id" : id[0].id
		                    // "bo_table" : "<?=$bo_table?>"
		                 
		                },
		                dataType: "json",
		                async: false,
		                cache: false,
		                success: function( data, textStatus ) {

		                    console.log(data);
		                    
		                  
		                },
		                error: function( xhr, textStatus, errorThrown ) {
		                    console.error( textStatus );
		                }
			        });
			    }
		    });
		//완료
		}else if ($(this).val()=="완료") {
			alert("적용되었습니다.");
			// location.reload();
		}
		
    });
});
</script>