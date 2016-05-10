<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php foreach($js as $one):?>
    <?php if($one):?>
        <script src="/assets/js/<?php echo $one;?>.js"></script>
    <?php endif;?>
<?php endforeach;?>

    <div class="clearfix"></div>
    <div class="container_15">
        <div class="grid_15">
            <div class="footer">
                
            </div>  
        </div>
    </div>
    
</body>
</html>