export const saveUserDetail = makeAction('SAVE_USER')
export const clearUser = makeAction('CLEAR_USER')
export const addPost = makeAction('ADD_POST')
export const deletePostItem = makeAction('DELETE_POST')

function makeAction(type){
  return ({ dispatch }, ...args) => dispatch(type, ...args)
}
