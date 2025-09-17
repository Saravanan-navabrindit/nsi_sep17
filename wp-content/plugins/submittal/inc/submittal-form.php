<div class="form-group">
    <label for="submittal-emails">Email address</label>
    <input 
        type="text"
        class="form-control"
        id="submittal-emails" 
        aria-describedby="email-help" 
        placeholder="Enter email"
    />
    <small
        id="email-help"
        class="form-text text-muted"
    >If you are entering mulitple email addresses, please use comma to separate</small>
</div>
<button id="submittal-submit-button"
    class="js-send-submittal-email btn btn-primary"
    disabled
>Submit</button>
<div class="g-recaptcha" data-callback="handleRecaptchaSuccess" data-sitekey="<?php echo GOOGLE_RECAPTCHA_KEY; ?>"></div>
<div class="form-check">
    <input type="checkbox" class="form-check-input" id="include-cover-letter">
    <label class="fs-6 form-check-label" for="include-cover-letter">Include cover letter</label>
</div>
<div id="cover-letter-fields" class="d-none">
    <div class="form-group">
        <label for="cover-letter-date">Date</label>
        <input type="date" class="form-control" id="cover-letter-date" />
    </div>
    <div class="form-group">
        <label for="cover-letter-project-name">Project Name</label>
        <input type="text" class="form-control js-cover-letter" id="cover-letter-project-name" />
        <div class="invalid-feedback">
            Max allowed length is 255 characters
        </div>
    </div>
    <div class="form-group">
        <label for="cover-letter-general-contractor">General Contractor</label>
        <input type="text" class="form-control js-cover-letter" id="cover-letter-general-contractor" />
        <div class="invalid-feedback">
            Max allowed length is 255 characters
        </div>
    </div>
    <div class="form-group">
        <label for="cover-letter-electrical-contractor">Electrical Contractor</label>
        <input type="text" class="form-control js-cover-letter" id="cover-letter-electrical-contractor" />
        <div class="invalid-feedback">
            Max allowed length is 255 characters
        </div>
    </div>
    <div class="form-group">
        <label for="cover-letter-engineer">Engineer/Architect</label>
        <input type="text" class="form-control js-cover-letter" id="cover-letter-engineer" />
        <div class="invalid-feedback">
            Max allowed length is 255 characters
        </div>
    </div>
    <div class="form-group">
        <label for="cover-letter-sales-contact">Sales Representative Contact</label>
        <input type="text" class="form-control js-cover-letter" id="cover-letter-sales-contact" />
        <div class="invalid-feedback">
            Max allowed length is 255 characters
        </div>
    </div>
</div><!-- .cover-letter -->
