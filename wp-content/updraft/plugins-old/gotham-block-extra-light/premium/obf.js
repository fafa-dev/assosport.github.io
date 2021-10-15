document.addEventListener("DOMContentLoaded", function(event) { 
		var classname = document.getElementsByClassName("kamesen"); 
		for (var i = 0; i < classname.length; i++) {
		//click gauche
		classname[i].addEventListener('click', kapsuleDcode, false);
		//click droit + central
		classname[i].addEventListener('contextmenu', myRightFunction);
		}
		}); 
		//fonction du click gauche
		var kapsuleDcode = function(event) {
			var attribute = this.getAttribute("datasin");               
					if(event.ctrlKey) {                   
						 var newWindow = window.open(decodeURIComponent(window.atob(attribute)), '_blank');                    
						 newWindow.focus();               
					} else {                    
						 document.location.href= decodeURIComponent(window.atob(attribute));
					}
			};
		//fonction du click droit
		var myRightFunction = function(event) {
			var attribute = this.getAttribute("datasin");               
				if(event.ctrlKey) {  
					event.preventDefault();
					 var newWindow = window.open(decodeURIComponent(window.atob(attribute)), '_blank');                    
					 newWindow.focus(); 
				} else {    
					event.preventDefault();		
					 window.open(decodeURIComponent(window.atob(attribute)),'_blank');	

				}
		}