function addExternalJavascriptToPage(scriptSource) {
	var script = [];
	script.push('var head = document.getElementsByTagName("head")[0];');
	script.push('var script = document.createElement("script");');
	script.push('script.type = "text/javascript";');
	script.push('script.src = "' + scriptSource + '";');
	script.push('head.appendChild(script);');
	eval(script.join(''));
}

function addExternalCssToPage(cssSource) {
	var css = [];
	css.push('var head = document.getElementsByTagName("head")[0];');
	css.push('var css = document.createElement("link");');
	css.push('css.type = "text/css";');
	css.push('css.rel = "stylesheet";');
	css.push('css.href = "' + cssSource + '";');
	css.push('head.appendChild(css);');
	eval(css.join(''));
}

function insertAfter(referenceNode, newNode) {
	if (referenceNode != null && referenceNode != 'undefined' &&
		referenceNode.parentNode != null && referenceNode.parentNode != 'undefined') {
		
		referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
	}
}

function createMissingPeopleFacebookWrapper() {
	var $innerDivHtml = $('<div>');
	$innerDivHtml.addClass('missing-people-wrapper');
	
	var $innerAHtml = $('<a>');
	$innerAHtml.attr('href', 'http://missingpeoplehelper.herokuapp.com');
	$innerAHtml.text('Missing People. Have you seen them?');
	
	$innerDivHtml.append($innerAHtml);
	
	$("#pagelet_composer").after($innerDivHtml);
}

function createPersonProfile(index, pData, vClass) {
	
	var $innerLiHtml = $('<li>');
	$innerLiHtml.attr('id', index);
	$innerLiHtml.addClass('person-wrapper');
	$innerLiHtml.addClass(vClass);
	
	var innerLiTextHtml = '<img src="'+pData.photo.url+'">'+	
						  '<span data-firstName="'+pData.firstName+'" data-lastName="'+pData.lastName+'">'+pData.firstName+'</span>';	
						  
	$innerLiHtml.append(innerLiTextHtml);	
	$('.people-image-carousel').append($innerLiHtml);
	
	var $innerInfoHtml = $('<div>')
	$innerInfoHtml.attr('id', 'info-'+index)
	$innerInfoHtml.addClass('person-info-wrapper')

    var innerInfoUlHtml = '<ul class="info">'+
						   '<li><b>Name: </b>'+pData.firstName+' '+pData.lastName+'</li>'+
						   '<li><b>Birth Date: </b>'+pData.birthDate+'</li>'+
						   '<li><b>City: </b>'+pData.city+' / '+pData.state+'</li>'+
						   '<li><b>Nationality: </b>'+pData.nationality+'</li>'+
						   '<li><b>Skin Color: </b>'+pData.skinColor+'</li>'+
						   '<li><b>Details: </b>'+pData.height+'cm / '+pData.weigth+'Kg / '+pData.sex+'</li>'+
						   '<li><b>Eyes Color: </b>'+pData.eyesColor+'</li>'+
						   '<li><b>Hair Color: </b>'+pData.hairColor+'</li>'+
						   '<li><b>Disappearance Date: </b>'+pData.disappearanceDate+'</li>'+
						   '<li><b>Disappearance City: </b>'+pData.disappearanceCity+'</li>'+
						   '<li><b>Other information: </b>'+pData.otherInformation+'</li>'+
						   '<li>If you have any information, please send e-mail to:<u>'+pData.contactEmail+'</u></li>'+
						   '</ul>';	
	$innerInfoHtml.append(innerInfoUlHtml);
	$('.people-information').append($innerInfoHtml);
}

// adding jQuery to the page context.
addExternalJavascriptToPage('https://missingpeoplehelper.herokuapp.com/MissingPeopleHelper/js/jquery.min.js');
//addExternalCssToPage('https://missingpeoplehelper.herokuapp.com/ChromeExtension/css/general.css');

window.setInterval(function(){
	// checking if the element has already been insert, if not insert it.
	if ($('.missing-people-wrapper').length <= 0) {
      $.ajaxSetup({
         headers: {'X-Parse-Application-Id': 's1F3uXdfPUqib5Eac1Q1yGQ5r9YTSNrCXHeXoH50',
               'X-Parse-REST-API-Key': 'BusCwZlgDcQ9C14yzaWN5NaCPtNSQdbWR9oWoPa8'}
      });

      $.ajax({
        url: "https://api.parse.com/1/classes/MissingPerson",
        dataType: "json",
        success: function(data) {
         if (typeof data === 'undefined') {
            //do nothing.
            console.error("Some error occurs during missing people integration.");
         }
         else {
            var results = data.results;
            
            if (typeof results !== 'undefined' && results.length != 0)  {
               createMissingPeopleFacebookWrapper();
               
               $('.missing-people-wrapper').append('<ul class="people-image-carousel">');
               
               $('.missing-people-wrapper').append('<div class="people-information">');
               $('.people-image-carousel').prepend('<li class="previous disabled arrow">&lt;</li>');
               for(index = 0; index < results.length; ++index) {
                  if(index < 4){
                     createPersonProfile(index, results[index], 'visible');
                  } else {
                     createPersonProfile(index, results[index], 'non-visible');
                  }
                  
               }
               if(results.length > 4){
                  $('.people-image-carousel').append('<li class="next arrow">&gt;</li>');
               } else {
                  $('.people-image-carousel').append('<li class="next disabled arrow">&gt;</li>');				
               }
               // Binding events
               $('.missing-people-wrapper ul li').hover(
                  function(e){			
                     $(this).find('span').text($(this).find('span').attr('data-firstName') + ' ' + $(this).find('span').attr('data-lastName'));
                  }, 
                  function(e){
                     $(this).find('span').text($(this).find('span').attr('data-firstName'));
                  }
               );
               $('.missing-people-wrapper ul li:not(.arrow)').click(function(e){
                  if ($(this).hasClass("selected")) {
                     $(".selected").removeClass("selected");
                     $('.people-information .person-info-wrapper').hide();
                  } 
                  else {
                     $(".selected").removeClass("selected");
                     $('.people-information div').hide();                    
                     $(this).addClass("selected");
                     $('.people-information #info-'+$(this).attr('id')).toggle();
                  }		
               });
               $('.missing-people-wrapper ul li.previous').click(function(e){
                  if(!$(this).parent().find("li:not(.previous)").first().hasClass("visible")){
                     if($(".visible").last().next("li:not(.next)")!=undefined){
                        $(".next").removeClass("disabled").css("display", "inline-block");
                     } else {
                        $(".next").addClass("disabled");
                     }
                     if($(".visible").first().prev("li:not(.previous)")!=undefined){
                        $(".visible").first().prev("li:not(.previous)").addClass("visible").removeClass("non-visible");
                     } else { 
                        $(this).addClass("disabled"); 
                     } 
                     $(".visible").last().addClass("non-visible").removeClass("visible");
                     if($(this).parent().find("li:not(.previous)").first().hasClass("visible")){
                        $(".previous").addClass("disabled");
                     }
                  }		
               });
               $('.missing-people-wrapper ul li.next').click(function(e){
                  if(!$(this).parent().find("li:not(.next)").last().hasClass("visible")){
                     if($(".visible").first().prev("li:not(.previous)")!=undefined){
                        $(".previous").removeClass("disabled").css("display", "inline-block");
                     } else {
                        $(".previous").addClass("disabled");
                     }
                     if($(".visible").last().next("li:not(.next)")!=undefined){
                        $(".visible").last().next("li:not(.next)").addClass("visible").removeClass("non-visible");
                     } else { 
                        $(this).addClass("disabled"); 
                     } 
                     $(".visible").first().addClass("non-visible").removeClass("visible");
                     if($(this).parent().find("li:not(.next)").last().hasClass("visible")){
                        $(".next").addClass("disabled");
                     }
                  }
               });
         }
        }
      }
      });
   }
}, 1500);
