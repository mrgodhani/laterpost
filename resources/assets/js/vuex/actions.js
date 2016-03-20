export const saveUserDetail = makeAction('SAVE_USER')
export const clearUser = makeAction('CLEAR_USER')

function makeAction(type){
  return ({ dispatch }, ...args) => dispatch(type, ...args)
}
