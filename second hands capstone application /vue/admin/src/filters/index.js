export function getAuthName(val){
  return Array.isArray(val)?val.join(','):''
}