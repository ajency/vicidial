import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'my-account-app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';
	constructor(private router : Router){
		this.router.navigateByUrl('/my-orders');
	}
}
