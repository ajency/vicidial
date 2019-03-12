import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
@Component({
  selector: 'app-product-page',
  templateUrl: './product-page.component.html',
  styleUrls: ['./product-page.component.scss']
})
export class ProductPageComponent implements OnInit {

  constructor(private route: ActivatedRoute,) { }

  ngOnInit() {
  	let product_slug = this.route.snapshot.paramMap.get('product_slug');
  	console.log("product_slug ==>", product_slug);
  }

}
