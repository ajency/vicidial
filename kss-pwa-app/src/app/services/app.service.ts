import { Injectable, isDevMode } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AppService {

	apiUrl : any = '';
  constructor() {
  	this.apiUrl = isDevMode() ? 'http://localhost:8000' : '';
  }
}
