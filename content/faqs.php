<style>
/* Style the element that is used to open and close the accordion class */

div.faq {margin:2px auto!important;}

p.accordion {
    color: #444;
    cursor: pointer;   
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
	margin:2px auto;
    
}

/* Add a background color to the accordion if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
p.accordion.active, p.accordion:hover { background-color:#ddd;}

/* Unicode character for "plus" sign (+) */
p.accordion:after {
    content: '\2795'; 
    font-size: 13px;
    color: #777;
    float: right;
    margin-left: 5px;
}

/* Unicode character for "minus" sign (-) */
p.accordion.active:after {
    content: "\2796"; 
}

/* Style the element that is used for the panel class */

div.panel {
    padding: 0 18px;
    background-color: #efefef;
    max-height: 0;
    overflow: hidden;
    transition: 0.4s ease-in-out;
    opacity: 0;
    margin-bottom:10px;
}

div.panel.show {
    opacity: 1;
    max-height: 500px; /* Whatever you like, as long as its more than the height of the content (on all screen sizes) */
}
</style>



<div class="col-md-12 page-title">Frequently Asked Questions</div>

<?php

$faqs = baseModel::listFAQs();

$num = 1;
foreach($faqs as $faq)
	{
	
	$quiz = $faq->quiz;
	$ans = $faq->answer;
	
	echo '<div class="col-md-12 faq">
			<p class="accordion"><label>Q'.$num.':</label> '.$quiz. '</p>
			<div class="panel"><label>Ans:</label> '.$ans. '</div>
		</div>';
	
	$num++;
	}

?>

<script>
// this one toggles only one open at a time
// Ref  - http://stackoverflow.com/questions/37745154/only-open-one-accordion-tab-at-one-time

document.addEventListener("DOMContentLoaded", function(event) 
	{ 
var acc = document.getElementsByClassName("accordion");
var panel = document.getElementsByClassName('panel');

for (var i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
        var setClasses = !this.classList.contains('active');
        setClass(acc, 'active', 'remove');
        setClass(panel, 'show', 'remove');

        if (setClasses) {
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
}

function setClass(els, className, fnName) {
    for (var i = 0; i < els.length; i++) {
        els[i].classList[fnName](className);
    }
}

});
</script>

