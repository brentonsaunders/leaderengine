<div class="form" id="login">
    <form name="login">
        <h1>Log In</h1>
        <p class="error"></p>
        <label>
            <span>Email</span>
            <input name="email" type="text" />
        </label>
        <label>
            <span>Password</span>
            <input name="password" type="password" />
        </label>
        <p class="forgot-password"><a name="forgot-password">Forgot password?</a></p>
        <input type="submit" value="Login" />
        <p>Don't have an account? <a name="signup">Sign Up</a></p>
    </form>
</div>
<div class="form" id="signup">
    <form name="signup">
        <h1>Sign Up</h1>
        <p class="error">error</p>
        <label>
            <span>Work Email</span>
            <input name="email" type="text" />
        </label>
        <label>
            <span>Name</span>
            <input name="name" type="text" />
        </label>
        <label>
            <span>Password</span>
            <input name="password" type="password" />
        </label>
        <label>
            <span>Confirm Password</span>
            <input name="repassword" type="password" />
        </label>
        <label class="terms">
            <input checked name="agree" type="checkbox" /><span>Agree with <a>Terms</a> and <a>Privacy Policy</a></span>
        </label>
        <input cname="signup" type="submit" value="Sign Up" />
        <p>Already have an account? <a name="login">Log In</a></p>
    </form>
</div>
<div class="form" id="forgot-password">
    <form name="forgot-password">
        <h1>Forgot Password</h1>
        <p class="error"></p>
        <label>
            <span>Email</span>
            <input name="email" type="text" />
        </label>
        <p><a name="login">Back to Login</a></p>
        <input name="send" type="submit" value="Send" />
    </form>
</div>
<div class="form" id="reset-password">
    <form name="reset-password" class="error">
        <h1>Reset Password</h1>
        <p class="error"></p>
        <p class="reset">Your password has been reset.</p>
        <label>
            <span>Password</span>
            <input name="password" type="password" />
        </label>
        <label>
            <span>Confirm Password</span>
            <input name="repassword" type="password" />
        </label>
        <input name="reset" type="submit" value="Reset Password" />
        <p><a name="login">Back to Login</a></p>
    </form>
</div>
<div class="form" id="verify-email">
    <form name="verify">
        <h1>Verify Account</h1>
        <p class="error"></p>
        <p class="verified">Your email has been verified.</p>
        <p>Please enter the verification code we sent to your email address</p>
        <label>
            <span>Code</span>
            <input name="code" type="number" />
        </label>
        <p class="resend">Resend Code</p>
        <input type="submit" value="Verify" />
        <p><a name="login">Back to Login</a></p>
    </form>
</div>
<div class="form" id="email-sent">
    <form>
        <h1>Email Sent</h1>
        <p class="error"></p>
        <p>An email has been sent containing a link to reset your password</p>
        <p><a name="login">Back to Login</a></p>
    </form>
</div>