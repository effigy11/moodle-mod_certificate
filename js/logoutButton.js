<script type="text/javascript">
YUI().use('transition', 'button-plugin', 'cssbutton', function(Y){
    
    // An event button, listening for a click
    var eventButton = Y.Plugin.Button.createNode({
        srcNode:'input[id*="single_button"]'
    });
    
    eventButton.on('click', function(){
            node = Y.one('#logoutButton');
            node.show();
            //alert("You clicked a button");
    });
});
</script>


