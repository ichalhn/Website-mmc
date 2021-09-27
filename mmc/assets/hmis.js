
var my_skins = [
	"skin-blue",
	"skin-black",
	"skin-red",
	"skin-yellow",
	"skin-purple",
	"skin-green",
	"skin-blue-light",
	"skin-black-light",
	"skin-red-light",
	"skin-yellow-light",
	"skin-purple-light",
	"skin-green-light"
];
	
	
// $(function() {
// 	/*topClock*/
// 	//alert("fired");
// 	$('#jclock1').jclock({
// 		format: '%A, %d %B %Y %I:%M:%S %p' // 12-hour
// 	});
	
// 	$.get( baseurl+"ajax/getSkin", function( data ) {
// 		store('skin', data);
// 	});
	
// 	var tmp = get('skin');
	
//     if (tmp && $.inArray(tmp, my_skins))
//       change_skin(tmp);
	  
//     //Add the change skin listener
//     $("[data-skin]").click(
// 		function(){
// 			//e.preventDefault();
// 			change_skin($(this).data('skin'));
// 			$("#skin").val($(this).data('skin'));
//     });
	
//     $("#browseBtn").click(function(event, numFiles, label) {
// 		var fileinput = $(this).parents('.input-group').find(':file')
// 		if (fileinput != null) {fileinput.focus().trigger('click');}
// 	});
	
// 	$( ":file" ).change(function() {
// 		//alert( "Handler for .change() called." );
// 		var input = $(this),
// 		numFiles = input.get(0).files ? input.get(0).files.length : 1,
// 		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
// 		input.trigger('fileselect', [numFiles, label]);
// 	});

// 	$(':file').on('fileselect', function (event, numFiles, label) {
// 		var input = $(this).parents('.input-group').find(':text'),
// 		log = numFiles > 1 ? numFiles + ' files selected' : label;
// 		if (input.length) {
// 			input.val(log);
// 		}// else {
// 			//if (log) alert(log);
// 		//}
// 	});

// 	$('.filefield').click(function(event, numFiles, label) {
// 		var fileinput = $(this).parents('.input-group').find(':file');
// 		if (fileinput != null) {fileinput.focus().trigger('click');}
// 	});
	
// 	$('.header-uphoto').click(function(event, numFiles, label) {
// 		var fileinput = $(this).parents('.user-header').find(':file');
// 		if (fileinput != null) {fileinput.focus().trigger('click');}
// 	});
// 	$('#user-txt').css("display", "none");
	
// 	$('.dropdown.user.user-menu').click(function(event){
// 		var events = $._data(document, 'events') || {};
// 		var target = event.target.nodeName;
// 		events = events.click || [];
// 		for(var i = 0; i < events.length; i++) {
// 			if(events[i].selector) {

// 				//Check if the clicked element matches the event selector
// 				if($(event.target).is(events[i].selector)) {
// 					events[i].handler.call(event.target, event);
// 				}

// 				// Check if any of the clicked element parents matches the 
// 				// delegated event selector (Emulating propagation)
// 				$(event.target).parents(events[i].selector).each(function(){
// 					events[i].handler.call(this, event);
// 				});
// 			}
// 		}
// 		event.stopPropagation(); //Always stop propagation
// 		if( (target != 'INPUT') && (event.target.id != 'user-input') )
// 			$('#user-txt').css("display", "none");
// 		else{
// 			$('#user-txt').css("display", "");
// 			$('#user-txt').focus();
// 		}
// 	});
// 	$('#userfile2').change(function(){	
// 		var formData = new FormData($('#chUserPhoto')[0]);
// 		$.ajax({
// 			dataType: "json",
// 			type: 'POST',
// 			async: false,
// 			cache: false,
// 			contentType: false,
// 			processData: false,
// 			url: baseurl+'Admin/update_photo',
// 			data: formData,
// 			success: function (response) {
// 				if(response.success){
// 					foto = baseurl+'/upload/user/'+response.photo;		
// 					$('.fotouser').attr("src",foto);
// 				}
// 			}
// 		});
// 	})
	
// 	$('#chUserName').on('submit', function (e) {
	
//         e.preventDefault();
// 		$.ajax({
// 			dataType: "JSON",
// 			type: 'POST',
// 			data: $('#chUserName').serialize(),
// 			url: baseurl+'Admin/update_name',
// 			success: function (response) {
// 				if(response.success){
// 					$('#uname-txt').html(response.name);
// 				}
// 			}
// 		});
// 	});
// });

var openUrl = function (urlContent) {
	window.history.pushState('','',urlContent);	
					
	$.ajax({url:urlContent+'?rel=tab',success: function(data){
		$('#container-fluid').html(data);
		$("#container-fluid").find("script").each(function(i) {
			//eval($(this).text());
		});
	}});	
	return false;  
};       
	
function chooseApp(obj) {
	if (obj.checked){
		//alert("checked!");
		$(obj).parent().parent().addClass("selected");
	}else{
		//alert("unchecked!");
		if ( $(obj).parent().parent().hasClass('selected') ) {
			$(obj).parent().parent().removeClass('selected');
		}
	}
}	


function change_skin(cls) {
	$.each(my_skins, function (i) {
		$("body").removeClass(my_skins[i]);
	});

	$("body").addClass(cls);
	//store('skin', cls);
	return false;
}


  /**
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function store(name, val) {
    if (typeof (Storage) !== "undefined") {
      localStorage.setItem(name, val);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
  }

  /**
   * Get a prestored setting
   *
   * @param String name Name of of the setting
   * @returns String The value of the setting | null
   */
  function get(name) {
    if (typeof (Storage) !== "undefined") {
      return localStorage.getItem(name);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
  }
