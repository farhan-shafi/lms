<div class="container mt-4">
    <div class="row">
        <!-- Settings Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Settings</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?php echo base_url('settings'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') ? 'active' : ''; ?>">
                        <i class="fa fa-cog me-2"></i> General
                    </a>
                    <a href="<?php echo base_url('settings/payment'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'payment') ? 'active' : ''; ?>">
                        <i class="fa fa-credit-card me-2"></i> Payment
                    </a>
                    <a href="<?php echo base_url('settings/email'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'email') ? 'active' : ''; ?>">
                        <i class="fa fa-envelope me-2"></i> Email
                    </a>
                    <a href="<?php echo base_url('settings/appearance'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'appearance') ? 'active' : ''; ?>">
                        <i class="fa fa-paint-brush me-2"></i> Appearance
                    </a>
                    <a href="<?php echo base_url('settings/certificates'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'certificates') ? 'active' : ''; ?>">
                        <i class="fa fa-certificate me-2"></i> Certificates
                    </a>
                    <a href="<?php echo base_url('settings/maintenance'); ?>" class="list-group-item list-group-item-action <?php echo ($this->uri->segment(2) == 'maintenance') ? 'active' : ''; ?>">
                        <i class="fa fa-wrench me-2"></i> Maintenance
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Settings</h5>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo form_open('settings/payment'); ?>
                        <h6 class="mb-3">Currency Settings</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="currency">Currency</label>
                                    <select name="currency" id="currency" class="form-control" required>
                                        <option value="">-- Select Currency --</option>
                                        <option value="USD" <?php echo (isset($settings['currency']) && $settings['currency'] == 'USD') ? 'selected' : ''; ?>>US Dollar (USD)</option>
                                        <option value="EUR" <?php echo (isset($settings['currency']) && $settings['currency'] == 'EUR') ? 'selected' : ''; ?>>Euro (EUR)</option>
                                        <option value="GBP" <?php echo (isset($settings['currency']) && $settings['currency'] == 'GBP') ? 'selected' : ''; ?>>British Pound (GBP)</option>
                                        <option value="INR" <?php echo (isset($settings['currency']) && $settings['currency'] == 'INR') ? 'selected' : ''; ?>>Indian Rupee (INR)</option>
                                        <option value="AUD" <?php echo (isset($settings['currency']) && $settings['currency'] == 'AUD') ? 'selected' : ''; ?>>Australian Dollar (AUD)</option>
                                        <option value="CAD" <?php echo (isset($settings['currency']) && $settings['currency'] == 'CAD') ? 'selected' : ''; ?>>Canadian Dollar (CAD)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="currency_symbol">Currency Symbol</label>
                                    <input type="text" name="currency_symbol" id="currency_symbol" class="form-control" 
                                           value="<?php echo isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '$'; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="mb-3">PayPal Settings</h6>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="enable_paypal" id="enable_paypal" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['enable_paypal']) && $settings['enable_paypal'] == 1) ? 'checked' : ''; ?>>
                            <label for="enable_paypal" class="form-check-label">Enable PayPal</label>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="paypal_email">PayPal Email</label>
                            <input type="email" name="paypal_email" id="paypal_email" class="form-control" 
                                   value="<?php echo isset($settings['paypal_email']) ? $settings['paypal_email'] : ''; ?>">
                        </div>
                        
                        <div class="form-check mb-4">
                            <input type="checkbox" name="paypal_sandbox" id="paypal_sandbox" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['paypal_sandbox']) && $settings['paypal_sandbox'] == 1) ? 'checked' : ''; ?>>
                            <label for="paypal_sandbox" class="form-check-label">Use PayPal Sandbox (Testing)</label>
                        </div>
                        
                        <h6 class="mb-3">Stripe Settings</h6>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="enable_stripe" id="enable_stripe" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['enable_stripe']) && $settings['enable_stripe'] == 1) ? 'checked' : ''; ?>>
                            <label for="enable_stripe" class="form-check-label">Enable Stripe</label>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="stripe_public_key">Stripe Public Key</label>
                            <input type="text" name="stripe_public_key" id="stripe_public_key" class="form-control" 
                                   value="<?php echo isset($settings['stripe_public_key']) ? $settings['stripe_public_key'] : ''; ?>">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="stripe_secret_key">Stripe Secret Key</label>
                            <input type="password" name="stripe_secret_key" id="stripe_secret_key" class="form-control" 
                                   value="<?php echo isset($settings['stripe_secret_key']) ? $settings['stripe_secret_key'] : ''; ?>">
                        </div>
                        
                        <div class="form-check mb-4">
                            <input type="checkbox" name="stripe_test_mode" id="stripe_test_mode" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['stripe_test_mode']) && $settings['stripe_test_mode'] == 1) ? 'checked' : ''; ?>>
                            <label for="stripe_test_mode" class="form-check-label">Use Stripe Test Mode</label>
                        </div>
                        
                        <h6 class="mb-3">Bank Transfer Settings</h6>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="enable_bank_transfer" id="enable_bank_transfer" class="form-check-input" 
                                   value="1" <?php echo (isset($settings['enable_bank_transfer']) && $settings['enable_bank_transfer'] == 1) ? 'checked' : ''; ?>>
                            <label for="enable_bank_transfer" class="form-check-label">Enable Bank Transfer</label>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="bank_details">Bank Account Details</label>
                            <textarea name="bank_details" id="bank_details" class="form-control" rows="4"><?php echo isset($settings['bank_details']) ? $settings['bank_details'] : ''; ?></textarea>
                            <div class="form-text">This information will be shown to students who choose to pay via bank transfer.</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
