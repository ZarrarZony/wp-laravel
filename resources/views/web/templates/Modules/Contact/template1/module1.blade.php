<div class="innerContainer">
    <div class="contentWrpr">
        <h1 class="pageTitle">Need To Contact Us? We Are <span>Here To Help!</span></h1>
        <p class="pageSubTitle">We love compliments, but suggestions are pretty great too, let us know what’s on your mind!</p>
        <div class="flexWrap">
            <div class="formWrapper">
                <form>
                    <div class="inputWrapper">
                        <label>Full Name*</label>
                        <input type="text" name="name" value="" id="input-name" required="">
                    </div>
                    <div class="inputWrapper">
                        <label>Email Address*</label>
                        <input type="text" name="email" value="" id="input-email" required="">
                    </div>
                    <div class="inputWrapper">
                        <label>Contact No</label>
                        <input type="text" name="fone" value="">
                    </div>
                    <div class="inputWrapper">
                        <label>Subject*</label>
                        <input type="text" name="subject" value="" required="">
                    </div>
                    <div class="inputWrapper">
                        <label>Message*</label>
                        <textarea name="enquiry" rows="10" id="input-enquiry" required=""></textarea>
                    </div>
                    <button type="submit">Submit Message</button>
                </form>
            </div>
            <div class="contLocation">
                <div class="contactBg" style="background-image: url({{ asset('build/images/maps.jpg') }});">
                </div>
            </div>
        </div>
    </div>
</div>