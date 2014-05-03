function testT() {
	console.log($('body'));
}

testArray = ['a','b','c'];


/*$.ajaxSetup({
	headers: {'X-Parse-Application-Id': 's1F3uXdfPUqib5Eac1Q1yGQ5r9YTSNrCXHeXoH50',
			'X-Parse-REST-API-Key': 'BusCwZlgDcQ9C14yzaWN5NaCPtNSQdbWR9oWoPa8'}
});

$.ajax({
  url: "https://api.parse.com/1/classes/MissingPerson",
  dataType: "json",
  success: function(data) {
	if (typeof data === 'undefined') {
	  $(".error").show();
	} else {
	  $(".success").show();
	  var results = data.results;
	  for(index = 0; index < results.length; ++index) {
		console.log(results[index]);
		$('#missing-people-helper').append(JSON.stringify(results[index])+'</br></br>');
	  }
	}
  }
});*/