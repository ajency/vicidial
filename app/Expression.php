<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Expression extends Model
{
    protected $casts = [
        'value' => 'array',
    ];
    public function parent()
    {
        return $this->morphTo();
    }

    public function validate($data){
    	switch($this->filter){
    		case 'greater_than':
    			switch ($this->entity) {
    				case 'cart_price':
    					return ($data['final_total'] >= $this->value[0]);
    					break;		
    				default:
    					return false;
    					break;
    			}
    			break;
            case 'less_than':        
                switch ($this->entity) {
                    case 'days':
                        if ($this->value[0] == 0) {
                            return false;
                            break;
                        }
                        return ($data['days'] <= $this->value[0]);
                        break;          
                }
                break; 
    		default:
    			return false;
    			break;
    	}
    }
}