export const saveUserDetail = makeAction('SAVE_USER')
export const clearUser = makeAction('CLEAR_USER')
export const addPost = makeAction('ADD_POST')
export const updatePost = makeAction('UPDATE_POST')
export const deletePostItem = makeAction('DELETE_POST')
export const deleteTwitterAccount = makeAction('DELETE_TWITTER_ACCOUNT')
export const updateTimezone = makeAction('UPDATE_TIMEZONE')
export const updateEmail = makeAction('UPDATE_EMAIL')
export const updateDomain = makeAction('UPDATE_DOMAIN')
export const removeBitly = makeAction('DELETE_BITLY')

function makeAction(type){
  return ({ dispatch }, ...args) => dispatch(type, ...args)
}
