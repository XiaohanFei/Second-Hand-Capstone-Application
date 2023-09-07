import { Notification  } from 'element-ui'
/**
 * 滚动到顶部
 * @param target
 * @param duration
 */ 
export function scrollToTop(target,duration) {
  duration = (typeof (duration) === 'undefined') ? 20 : duration
  let el = document.querySelector(target);
  let step = 0;
  let interval = setInterval(() => {
    if (el.scrollTop <= 0) {
      clearInterval(interval);
      return;
    }
    step += 10;
    el.scrollTop -= step;
  }, duration);
}

/**
 * 消息通知
 * @param msg
 * @param type
 */
export function notification(msg,type){
  type = type || 'error'
  var title = type=='success'?"Success":'Error'
  if(msg && msg.length > 0){
    Notification({
      title: title,
      message: msg,
      type: type,
      duration:4000
    })
  }
}

/**
 * 一维数组转多维数组
 * @param list
 * @param pid
 */
export function listToTree(list, pid) {
  return list.filter(item => {
    if (item.pid === pid) {
      item.children = listTotree(list, item.id)
      return true
    }
    return false
  })
}

/**
 * 树形数组转一维数组
 * @param list
 * @param pid
 * @returns {*}
 */
export function treeToList(treeData) {
  const arr = []
  const expanded = data => {
    if (data && data.length > 0) {
      data.filter(d => d).forEach(e => {
        arr.push(e)
        expanded(e['children'] || [])
      })
    }
  }
  expanded(treeData)
  return arr
}

/**
 * 下载文件
 * @param url
 * @param title
 * @returns {Array}
 */
export function downloadFile(fileUrl,title) {
  let link = document.createElement('a')
  let url = window.sourceUrl + fileUrl
  fetch(url).then(res => res.blob()).then(blob => {
    link.href = URL.createObjectURL(blob)
    // console.log(link.href)
    link.download = title
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link);
  })
}



