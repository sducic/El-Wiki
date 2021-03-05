var edit = function() {
  $('.click2edit').summernote({focus: true});
};

var save = function() {
	
	  
	  var markup = $('.click2edit').summernote('code');
	  $('.click2edit').summernote('destroy');
	  
	/*
	var text = document.getElementById("menjamo").textContent;
	bootbox.confirm({
		message: "This is a confirm with custom button text and color! Do you like it?",
		buttons: {
			confirm: {
				label: 'Save',
				className: 'btn-success'
				
			},
			cancel: {
				label: 'Cancel',
				className: 'btn'
			}
		},
		callback: function (result) {
			if(result==true)
			{	
				var markup = $('.click2edit').summernote('code');
				$('.click2edit').summernote('destroy');
			}
			else
			{
				//document.querySelector("#menjamo").html(text);
				$("div[id=menjamo]").html(text);
				//$("div#menjamo").html(text);
				var markup = $('.click2edit').summernote('code');
				$('.click2edit').summernote('destroy');
				//$('#summernote').summernote('reset');
			}*/
			/*
			callback: function (result) {
			if (result === true) {
				var markup = $('#summernote').summernote('code');
				$('#summernote').summernote('destroy');
			}
			else {
				var markup1 = $('#summernote').summernote('code');
				$('#summernote').summernote('reset');
				//$('#summernote').summernote( 'disable' );
			}
			
				
			}*//*
		}
	});*/
 
};


