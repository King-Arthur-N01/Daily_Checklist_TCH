jQuery(document).ready(function() {
    
        var $body = jQuery('body');
    
        jQuery('#parallax .parallax-layer').parallax({
            mouseport: $body,
            yparallax: false,
            xparallax: -0.05,
            frameDuration: 30,
            xorigin: 0.5,
            yorigin: 0 
        });
        
        jQuery('#parallax .parallax-layer:first-child').parallax({
            mouseport: $body,
            yparallax: 0.1,
            xparallax: 0.1,
            frameDuration: 40,
            xorigin: 0.5,
            yorigin: 0
        });
        
        jQuery('#parallax .parallax-layer:last-child').parallax({
            mouseport: $body,
            yparallax: -0.1,
            xparallax: 0.05,
            frameDuration: 40,
            xorigin: 0.5,
            yorigin: 0
             
        });
 
});

var current = 0;

function scrollBg(wrapper, step, right){
        
        if(right) {
                
                current += step;
        
        } else {
		
                current -= step;
        
        }
        
		jQuery('#'+wrapper).css('background-position',current+'px 0');

}

var init = setInterval('scrollBg("moving-background", 1)', 50);