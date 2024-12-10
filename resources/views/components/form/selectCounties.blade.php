
@foreach(\App\Models\Country::orderBy('sort_order', 'DESC')->orderBy('name', 'ASC')->get() as $country)
    <option value="{{$country->id}}">{{$country->name}}</option>
@endforeach
