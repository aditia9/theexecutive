define(['jquery','uiRegistry'], function ($, uiRegistry) {
    'use strict';

    return function (Region) {
        return Region.extend({
        	// initialize : function(){
        	// 	this._super();
        	// 	var city = uiRegistry.get(this.parentName + '.' + 'city');
         //    	$( '#'+city.uid ).empty().trigger('change');

        	// 	return this;
        	// },
        	onUpdate: function (value) {
            	var city = uiRegistry.get(this.parentName + '.' + 'city');
            	$( '#'+city.uid ).empty().trigger('change');
            	var country = uiRegistry.get(this.parentName + '.' + 'country_id')
	            if (country.value() && value) {
	                $.ajax({
				          method: "POST",
				          url: "/hypeworkshipping/city/ajaxlist",
				          data: { region_id: value },
				          dataType: "json"
			        })
			      	.done(function( msg ) {
			      		$( '#'+city.uid ).empty().append(msg.htmlcontent);
			      	});
	            }
	            return this._super();
	        }
        });
    }
});
