<!-- Slider Wrapper -->

<div id="home-slider" class="home-slider">
  <!-- Slider items/slides -->
  @foreach($banners as $banner)
    @include('includes.banner.slide', ['banner' => $banner])
  @endforeach
</div>
