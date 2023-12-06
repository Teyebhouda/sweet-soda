<div class="gshop-sidebar bg-white rounded-2 overflow-hidden">
    <!--Filter by search-->
    <div class="sidebar-widget search-widget bg-white py-5 px-4">
        <div class="widget-title d-flex">
            <h6 class="mb-0 flex-shrink-0">{{ localize('Rechercher maintenant') }}</h6>
            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
        </div>
        <div class="search-form d-flex align-items-center mt-4">
            <input type="hidden" name="view" value="{{ request()->view }}">
            <input type="text" id="search" name="search"
                @isset($searchKey)
       value="{{ $searchKey }}"
       @endisset
                placeholder="{{ localize('Recherche') }}">
            <button type="submit" class="submit-icon-btn-secondary"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
    <!--Filter by search-->

    
<!--Filter by Categories-->
<div class="sidebar-widget category-widget bg-white py-5 px-4 border-top mobile-menu-wrapper scrollbar h-400px">
    <div class="widget-title d-flex">
        <h6 class="mb-0 flex-shrink-0">{{ localize('Catégories') }}</h6>
        <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
    </div>
    <ul class="widget-nav mt-4">
        @php
            $product_listing_categories = getSetting('product_listing_categories') != null ? json_decode(getSetting('product_listing_categories')) : [];
            $categories = \App\Models\Category::whereIn('id', $product_listing_categories)->get();
        @endphp

        @foreach ($categories as $category)
            @php
                $productsCount = \App\Models\ProductCategory::where('category_id', $category->id)->count();
            @endphp
            <li class="category-item" data-category-id="{{ $category->id }}">
                <div class="toggle-wrapper">
                    <a href="javascript:void(0);" class="d-flex justify-content-between align-items-center toggle-category" data-category-id="{{ $category->id }}">
                        @if($category->childrenCategories->isNotEmpty())
                            <i class="toggle-icon">▼</i>
                        @else
                            <i class="toggle-icon" style="visibility: hidden;">▼</i>
                        @endif
                        <span class="category-name">{{ $category->collectLocalization('name') }}</span>
                        <span class="fw-bold fs-xs total-count">{{ $productsCount }}</span>
                    </a>
                    <ul class="child-categories" data-category-id="{{ $category->id }}" style="display: none;">
                        @foreach($category->childrenCategories as $childCategory)
                            <li>
                                <a href="javascript:void(0);"
                                    class="d-flex justify-content-between align-items-center toggle-category" data-category-id="{{ $childCategory->id }}">
                                    @if($childCategory->childrenCategories->isNotEmpty())
                                        <i class="toggle-icon">▼</i>
                                    @else
                                        <i class="toggle-icon" style="visibility: hidden;">▼</i>
                                    @endif
                                    <span class="category-name">{{ $childCategory->collectLocalization('name') }}</span>
                                    <span class="fw-bold fs-xs total-count">{{ $childCategory->productsCount }}</span>
                                </a>
                                <ul class="grandchild-categories" data-category-id="{{ $childCategory->id }}" style="display: none;">
                                    @foreach($childCategory->childrenCategories as $grandchildCategory)
                                        <li>
                                            <a href="javascript:void(0);"
                                                class="d-flex justify-content-between align-items-center toggle-category" data-category-id="{{ $grandchildCategory->id }}">
                                                @if($grandchildCategory->childrenCategories->isNotEmpty())
                                                    <i class="toggle-icon">▼</i>
                                                @else
                                                    <i class="toggle-icon" style="visibility: hidden;">▼</i>
                                                @endif
                                                <span class="category-name">{{ $grandchildCategory->collectLocalization('name') }}</span>
                                                <span class="fw-bold fs-xs total-count">{{ $grandchildCategory->productsCount }}</span>
                                            </a>
                                            <!-- Add another level if needed -->
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('.toggle-wrapper .toggle-category').off('click').on('click', function (e) {
            e.stopPropagation(); 

            var categoryId = $(this).data('category-id');

            var $childCategories = $('.child-categories[data-category-id="' + categoryId + '"]');
            $childCategories.slideToggle();

            $(this).find('.toggle-icon').text(function (_, text) {
                return text === '▼' ? '▲' : '▼';
            });

            if ($childCategories.is(':visible')) {
                console.log('Dropdown opened for category with ID: ' + categoryId);
            } else {
                console.log('Dropdown closed for category with ID: ' + categoryId);
            }
        });

        $('.toggle-wrapper .grandchild-categories').hide();

        $('.toggle-wrapper .child-categories .toggle-category').off('click').on('click', function (e) {
            e.stopPropagation(); 

            var categoryId = $(this).data('category-id');

            var $grandchildCategories = $('.grandchild-categories[data-category-id="' + categoryId + '"]');
            $grandchildCategories.slideToggle();

            $(this).find('.toggle-icon').text(function (_, text) {
                return text === '▼' ? '▲' : '▼';
            });

            if ($grandchildCategories.is(':visible')) {
                console.log('Dropdown opened for category with ID: ' + categoryId);
            } else {
                console.log('Dropdown closed for category with ID: ' + categoryId);
            }
        });

        $('.toggle-wrapper .category-name.toggle-category').off('click').on('click', function () {
            var categoryId = $(this).data('category-id');

            // Remove the following line to enable navigation
             window.location.href = '{{ route('products.index') }}?&category_id=' + categoryId;
        });
    });
</script>
<!--Filter by Categories-->





    <!--Filter by Price-->
    <div class="sidebar-widget price-filter-widget bg-white py-5 px-4 border-top">
        <div class="widget-title d-flex">
            <h6 class="mb-0 flex-shrink-0">{{ localize('Filtrer par prix') }}</h6>
            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
        </div>
        <div class="at-pricing-range mt-4">
            <form class="range-slider-form">
                <div class="price-filter-range"></div>
                <div class="d-flex align-items-center mt-3">
                    <input type="number" min="0" oninput="validity.valid||(value='0');"
                        class="min_price price-range-field price-input price-input-min" name="min_price"
                        data-value="{{ $min_value }}" data-min-range="0">
                    <span class="d-inline-block ms-2 me-2 fw-bold">-</span>

                    <input type="number" max="{{ $max_range }}"
                        oninput="validity.valid||(value='{{ $max_range }}');"
                        class="max_price price-range-field price-input price-input-max" name="max_price"
                        data-value="{{ $max_value }}" data-max-range="{{ $max_range }}">

                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-3">{{ localize('Filtrer') }}</button>
            </form>
        </div>
    </div>
    <!--Filter by Price-->

    <!--Filter by Tags-->
    <div class="sidebar-widget tags-widget py-5 px-4 bg-white">
        <div class="widget-title d-flex">
            <h6 class="mb-0">{{ localize('Mots-clés') }}</h6>
            <span class="hr-line w-100 position-relative d-block align-self-end ms-1"></span>
        </div>
        <div class="mt-4 d-flex gap-2 flex-wrap">
            @foreach ($tags as $tag)
                <a href="{{ route('products.index') }}?&tag_id={{ $tag->id }}"
                    class="btn btn-outline btn-sm">{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
    <!--Filter by Tags-->
</div>
