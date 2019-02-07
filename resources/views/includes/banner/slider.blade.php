<!-- Slider Wrapper -->

<div id="home-slider" class="home-slider">
  <!-- Slider items/slides -->
  @foreach($banners as $banner)
    @include('includes.banner.slide', ['banner' => $banner, 'display_type' => 'Banner', 'class' => 'home-slide-item'])
  @endforeach
</div>
