import { AbilityBuilder, Ability } from "@casl/ability";

const { can, rules } =  new AbilityBuilder(Ability);
const loggedIn = localStorage.getItem('permissions')

var  permissions = null;

if(typeof loggedIn != 'undefined' || loggedIn != null ){

const userData = JSON.parse(loggedIn);
    permissions = userData;
}
can(permissions, 'all');

let ability = new Ability(rules);
export {ability };
