<?php
    $submittalTitle = 'Default';
    get_header(); 
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-6">
            <div class="d-flex align-items-end">
                <div class="form-group w-75 mb-0 mr-2">
                    <label for="submittals-list">My submittals</label>
                    <select class="form-control" id="submittals-list">
                        <option value="0" selected><?php echo $submittalTitle ?></option>
                    </select>
                </div><!-- .form-group -->
            </div>
        </div><!-- .col-6 -->
        <div class="col-6">
            <div class="d-flex align-items-end">
                <div class="form-group w-75 mb-0 mr-2">
                    <label for="submittal-title">Create new submittal</label>
                    <input type="text" class="form-control" id="submittal-title" placeholder="Title" />
                </div>
                <button class="btn btn-primary" id="add-submittal" disabled>Create</button>
            </div>
        </div><!-- .col-6 -->
    </div><!-- .row -->
    <div class="row mb-5">
        <div class="col-6"></div>
        <div class="col-6">
            <div class="invalid-feedback" id="title-validation-feedback">
                Max allowed length is 255 characters
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col my-4"><h2 class="text-center"><?php echo $submittalTitle ?> Submittal</h2></div>
    </div>
    <div id="empty-submittal" class="row my-4">
        <div class="col">
            <h3 class="text-center text-uppercase">Your project submittal is empty</h3>
            <h4 class="text-center my-3">Click <a href="<?php echo home_url('/shop'); ?>" class="text-uppercase text-muted">here</a> to continue browsing our products</h4>
        </div>
    </div>
</div>
<?php get_footer(); ?>