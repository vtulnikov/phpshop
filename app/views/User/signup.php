<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active"><?= getTranslatedPart('tpl_signup'); ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h1 class="section-title"><?= getTranslatedPart('tpl_signup'); ?></h1>

            <form class="row g-3" method="post">

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" value="<?= getFormData('email') ?>" class="form-control" id="email" placeholder="name@example.com">
                        <label class="required" for="email"><?= getTranslatedPart('tpl_signup_email_input'); ?></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" name="password" value="<?= getFormData('password') ?>" class="form-control" id="password" placeholder="password">
                        <label class="required" for="password"><?= getTranslatedPart('tpl_signup_password_input'); ?></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="name" value="<?= getFormData('name') ?>" class="form-control" id="name" placeholder="Name">
                        <label class="required" for="name"><?= getTranslatedPart('tpl_signup_name_input'); ?></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="address" value="<?= getFormData('address') ?>" class="form-control" id="address" placeholder="Address">
                        <label class="required" for="address"><?= getTranslatedPart('tpl_signup_address_input'); ?></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn btn-danger"><?= getTranslatedPart('user_signup_signup_btn'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

