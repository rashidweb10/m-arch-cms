<footer class="footer pt-md-5 pt-4 pb-md-2 pb-5" style="border-top: 1px dashed #5a5c5b;">
  <div class="container">
    <div class="row">
      <div class="col-md-2 width_1">
          <div class="footer_logo">
            <a href="/">
              <img title="MaxCrude" class="w-100" src="{{ uploaded_asset(get_setting('logo')) }}" />
            </a>
          </div>
      </div>
      
      <div class="col-md-2 width_2">
              
            <div class="footer-contacts" style="position: relative;">
             <i class="fa-solid fa-location-dot"></i>
              <p class="footer-contacts__address mb-0 pb-md-0 pb-3">{!! get_setting('address') !!}</p>
             
            </div>
      </div>
      
       <div class="col-md-2 width_3">
           <div class="footer-contacts">
             <i class="fa-solid fa-phone"></i>
              <p class="footer-contacts__address mb-0 pb-md-0"><a href="tel:{{get_setting('phone')}}">{{get_setting('phone')}}</a></p>
             
            </div>
            <div class="footer-contacts">
                <i class="fa-solid fa-envelope-open"></i>
              <p class="footer-contacts__address mb-0 pb-md-0"><a href="mailto:{{get_setting('email')}}">{{get_setting('email')}}</a></p>
            </div>
      </div>
      
      <div class="col-md-2 width_4">
            <div class="footer_link1">
              <ul class="footer-menu">
                <li>
                  <a href="{{ route('home') }}">HOME </a>
                </li>
                <li>
                  <a href="{{ route('about') }}">ABOUT US</a>
                </li>
                
              </ul>
            </div>
      </div>
      
      <div class="col-md-2 width_5">
            <div class="footer_link1">
              <ul class="footer-menu">
               
                <li>
                  <a href="{{ route('products') }}">PRODUCTS</a>
                </li>
                <li>
                  <a href="{{ route('contact') }}">CONTACT US</a>
                </li>
              </ul>
            </div>
      </div>
      
      
      
     <div class="col-md-2">
        
      </div>
      
      <div class="col-md-8">
        <p class="footer-copyright mb-0">© {{date("Y")}} {{get_setting('name')}}. All Rights Reserved.</p>
      </div>
      
      <div class="col-md-2 text-right">
        <p class="footer-copyright mb-0 copyrighr2">Powered by <a href="{{config('custom.author_url')}}" target="_blank" style="font-weight:bold">{{config("custom.author")}}</a></p>
      </div>
     
     
    
    </div>
  </div>
</footer>