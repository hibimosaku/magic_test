<nav class="lnav">
  <ul>
    @foreach($secondaryCategories->groupBy('primaryCategory') as $primaryCategory => $categories)
    @php
    $primaryCategoryObject = $categories->first()->primaryCategory;
    @endphp
    <li>
      <a href="{{ route('item.showBySecondaryCategory', ['secondarycategory' => $primaryCategoryObject]) }}">
        {{ $primaryCategoryObject->name }}
      </a>
    </li>
    <ul>
      @foreach($categories as $category)
      <li>
        <a href="{{ route('item.showByPrimaryCategory', ['secondarycategory' => $primaryCategoryObject,'primarycategory'=>$category->id]) }}">
          {{ $category->name }}
        </a>
      </li>
      @endforeach
    </ul>
    @endforeach
  </ul>








</nav>