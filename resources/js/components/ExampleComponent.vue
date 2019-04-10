<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'app',
  data () {
    return {
      search: '',
      shipment: []
    }
  },
  created() {
    axios.get('/address').then((response) => {
      this.shipment = response.data
    })
    .catch((e) => {
      console.error(e)
    })
  }
}
</script>
