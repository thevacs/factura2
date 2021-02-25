<div class="list-group">
  <a href="{{ route('inventarios.index') }}" class="list-group-item list-group-item-action {{ active(['inventarios', 'inventarios/*']) }}">
    <i class="fas fa-truck-moving"></i> Inventarios
  </a>
  <a href=" {{ route('manifiestos.index') }}" class="list-group-item list-group-item-action {{ active(['manifiestos', 'manifiestos/*']) }}">
    <i class="fas fa-book"></i> Manifiestos
  </a>
</div>
