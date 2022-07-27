
	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<a ><img style="margin-top: -19px;margin-left: -4px;" src="{{asset('backend/img/photot.png')}}" alt="#"></a>
								
							</div>
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<p class="text"></p>
							<p class="call">Vous avez une question ? Appelez-nous 24/24<span><a href="tel:$settings as $data"></a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Accueil</h4>
							<ul>
								<li><a href="{{route('product-grids')}}">Annonces</a></li>
								<li><a href="{{route('about-us')}}">À propos</a></li>
								<li><a href="{{route('contact')}}">Contacté nous</a></li>
								<li><a href="#">Help</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Spécialités</h4>
							<ul>
								
								
								
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Contactez-nous</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li><span>Address :</span></li>
									<li><span>E-mail :</span></li>
									<li><span>Téléphone :</span></li>
								</ul>
							</div>
							<div class= style="color: white;">
                            <a  href= target="blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="target="blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a>
                        </div>
							<!-- End Single Widget -->
							<!--<div class="sharethis-inline-follow-buttons"></div>-->
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner ">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © {{date('Y')}} <a href="{{route('home')}}" ></a>  -  All Rights Reserved.</p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->



	


	 
 
	<!-- Jquery -->
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->

	<script src="{{asset('frontend/js/active.js')}}"></script>
<script src="{{asset('frontend/js/dzayerjs.js')}}"></script>
	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>

<script>
	jQuery(document).ready(function(){

		jQuery('#state').change(function(){
			let state=jQuery(this).val();
			//alert(state);

			jQuery.ajax({
				url:"getcity",
       			 data:'state='+state+
       			 '&_token={{csrf_token()}}',
       			 type:"POST",
       			 success:function(result){
       			   jQuery('#city').html(result)
       			    $('#city').FormSelect();
       			   
       			 }
			});
		});

	});
</script>

<script>
  $('#state').change(function(){
    var state=$(this).val();
    // alert(state);

    if(state !=null){
      // Ajax call
      $.ajax({
        url:"/userproduct/"+state+"/cities",
        data:{
          _token:"{{csrf_token()}}",
          id:state
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
           //console.log(response);
          var html_option="<option value=''>----Select city----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#state_cat_div').removeClass('d-none');
              $.each(data,function(id,name){
                html_option +="<option value='"+id+"' selected>"+name+"</option>"
              });
            }

            else{
            }
            
          }
         else{
            $('#state_cat_div').addClass('d-none');
          }
          $('#city').html(html_option);
          
         
        }
      });
    }
    else{
    }
  });
</script>


<script>
/*JavaScript*/
    dzayer.build('#example4',{
      showNumbers :true,
      select : 'tizi', // or 'tizi ouezzo'  or 15
      communes : '#communes',
    });

  
  </script> 
<script type="text/javascript">
dzayer.build('.wialaya',{
     showNumbers :false,
     communes : '.commune',
     select : 'alger',
   });
document.querySelector('.form1').addEventListener('submit',function(e){
  e.preventDefault();
  var w = document.querySelector('.wialaya').value;
  var c = document.querySelector('.commune').value;
  alert('wilaya='+w+'&commune='+c);
})
</script>
