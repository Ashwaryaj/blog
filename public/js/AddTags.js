$(document).ready(function() {
    var tagApi = $(".tm-input").tagsManager();
    jQuery(".typeahead").typeahead({
	    name: 'tags',
	    displayKey: 'name',
    	source: function (query, process) {
        	return $.get('/tags', { query: query }, function (data) {
		        data = $.parseJSON(data);
		        return process(data);
        	});
      	},
	    afterSelect :function (item){
	    	tagApi.tagsManager("pushTag", item.name);
	    }
    });
    
});
