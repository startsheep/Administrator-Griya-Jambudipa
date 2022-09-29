import {
    defineAbility
} from '@casl/ability';
import Cookie from "js-cookie";

export default defineAbility(
    can => {
        if (Cookie.get('user') !== undefined) {
            const user = JSON.parse(Cookie.get('user'));

            // looping role and condition this
            user.role.forEach(role=>{
                switch (role){
                    case 'Admin':
                        can(['create','delete'], 'Customer');
                        can(['General Information', 'Main Menu', 'Master Data'], 'Menu');
                        can(['chart'],'Dashboard');
                        can(['Data Users'], 'General Information');
                        break;
                        case 'Staff':
                            can(['General Information', 'Main Menu'], 'Menu');
                        break;
                }
            })
        }
    }
);
