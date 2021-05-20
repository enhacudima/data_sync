import { AbilityBuilder, Ability } from "@casl/ability";

const { can, rules } =  new AbilityBuilder(Ability);

const loggedIn =  localStorage.getItem('permissions');
var  permissions = null;

if(loggedIn && loggedIn.length > 0 ){
    const userData = JSON.parse(loggedIn);
    permissions = userData;
    //console.log(permissions);
}
can(permissions, 'all');

let ability = new Ability(rules);
export {ability };
