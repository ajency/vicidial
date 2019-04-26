<?php

function generateProductListTitle($params, $facets)
{
    $title = "Fashion at KSS";
    if (!isset($params['primary_filter'])) {
        return $title;
    }

    switch (count($params['primary_filter'])) {
        case 1:
            if (isset($params['primary_filter']['product_category_type'])) {
                $title = $facets["product_category_type"]->keyBy('facet_value')[$params['primary_filter']['product_category_type'][0]]->display_name . " at KSS";
            } else if (isset($params['primary_filter']['product_age_group'])) {
                $title = $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name . " fashion store";
            } else if (isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name . " fashion store";
            } else if (isset($params['primary_filter']['product_brand'])) {
                $title = $facets["product_brand"]->keyBy('facet_value')[$params['primary_filter']['product_brand'][0]]->display_name . " fashion store";
            } else if (isset($params['primary_filter']['product_subtype'])) {
                $title = $facets["product_subtype"]->keyBy('facet_value')[$params['primary_filter']['product_subtype'][0]]->display_name . " at KSS";
            }
            break;
        case 2:
            if (isset($params['primary_filter']['product_category_type']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_category_type"]->keyBy('facet_value')[$params['primary_filter']['product_category_type'][0]]->display_name . " for " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name;
            } else if (isset($params['primary_filter']['product_category_type']) && isset($params['primary_filter']['product_age_group'])) {
                $title = $facets["product_category_type"]->keyBy('facet_value')[$params['primary_filter']['product_category_type'][0]]->display_name . " for " . $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name;
            } else if (isset($params['primary_filter']['product_age_group']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name . " - " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name . " fashion store";
            } else if (isset($params['primary_filter']['product_category_type'])) {
                $title = $facets["product_category_type"]->keyBy('facet_value')[$params['primary_filter']['product_category_type'][0]]->display_name . " at KSS";
            }
            break;
        case 3:
            if (isset($params['primary_filter']['product_category_type']) && isset($params['primary_filter']['product_age_group']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_category_type"]->keyBy('facet_value')[$params['primary_filter']['product_category_type'][0]]->display_name . " for " . $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name . " - " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name;
            } else if (isset($params['primary_filter']['product_subtype']) && isset($params['primary_filter']['product_age_group']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_subtype"]->keyBy('facet_value')[$params['primary_filter']['product_subtype'][0]]->display_name . " for " . $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name . " - " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name;
            } else if (isset($params['primary_filter']['product_subtype']) && isset($params['primary_filter']['product_age_group'])) {
                $title = $facets["product_subtype"]->keyBy('facet_value')[$params['primary_filter']['product_subtype'][0]]->display_name . " for " . $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name;
            } else if (isset($params['primary_filter']['product_subtype']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_subtype"]->keyBy('facet_value')[$params['primary_filter']['product_subtype'][0]]->display_name . " for " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name;
            }
            break;
        case 4:
            if (isset($params['primary_filter']['product_subtype']) && isset($params['primary_filter']['product_age_group']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_subtype"]->keyBy('facet_value')[$params['primary_filter']['product_subtype'][0]]->display_name . " for " . $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name . " - " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name;
            }
            break;
        case 5:
            if (isset($params['primary_filter']['product_subtype']) && isset($params['primary_filter']['product_age_group']) && isset($params['primary_filter']['product_gender'])) {
                $title = $facets["product_subtype"]->keyBy('facet_value')[$params['primary_filter']['product_subtype'][0]]->display_name . " for " . $facets["product_age_group"]->keyBy('facet_value')[$params['primary_filter']['product_age_group'][0]]->display_name . " - " . $facets["product_gender"]->keyBy('facet_value')[$params['primary_filter']['product_gender'][0]]->display_name;
            }
            break;
        default:
            break;
    }

    return $title;
}
