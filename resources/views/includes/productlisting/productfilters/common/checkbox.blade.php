<input type="checkbox" class="facet-category custom-control-input" id="@{{facet_value}}" onChange="@{{changeEvent}}" name="@{{template}}" value="@{{facet_value}}" @{{#if is_selected }} checked = "checked" @{{/if}} data-facet-name="@{{filter_facet_name}}" data-singleton="false" data-slug="@{{slug}}" @{{#if disabled_at_zero_count}} @{{#ifEquals count 0 }} disabled = "disabled" @{{/ifEquals}} @{{/if}} data-collapsable="@{{collapsed}}" data-attribute-slug="@{{attribute_slug}}" data-display-name="@{{display_name}}">