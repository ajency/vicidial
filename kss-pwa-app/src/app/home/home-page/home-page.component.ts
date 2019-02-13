import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';
// import menu from '../../../assets/data/menu.json';

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.scss']
})
export class HomePageComponent implements OnInit {

	menuObject : any
  constructor(private apiService: ApiService) { }

  ngOnInit() {
  	console.log("ngOnInit HomePageComponent");
  	// this.menuObject = menu.menu;
    let url = "https://demo8558685.mockable.io/get-menu";
  	this.apiService.request(url,'get',{},{}).then((data)=>{
  		console.log("data ==>", data);
  		this.menuObject = data.menu;
  	})
  	.catch((error)=>{
  		console.log("error in fetching the json",error);
  	})
  }

}
