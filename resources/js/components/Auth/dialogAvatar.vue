<template>
<div class="text-center">
    <v-dialog
      v-model="showDialogAvatar"
      width="500"

    >

      <v-card >
        <v-card-title class="headline grey lighten-2">
          Update Avatar
        </v-card-title>

        <v-card-text>
            <v-row justify="center">
                <a-form-item label="Picture">
                <div class="dropbox">
                <a-upload
                name="picture"
                list-type="picture-card"
                class="avatar-uploader"
                :show-upload-list="false"
                action="/data_sync/public/api/filePicture"
                :before-upload="beforeUpload"
                @change="handleChange"
                >
                <img v-if="imageUrl" :src="imageUrl" alt="avatar" class="picture_avatar" />
                <div v-else>
                    <a-icon :type="loading ? 'loading' : 'plus'" />
                    <div class="ant-upload-text">
                    Upload
                    </div>
                </div>
                </a-upload>

                </div>
                </a-form-item>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="changeAvatar()"
          >
            Update
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
function getBase64(img, callback) {
  const reader = new FileReader();
  reader.addEventListener('load', () => callback(reader.result));
  reader.readAsDataURL(img);
}
function hasErrors(fieldsError) {
  return Object.keys(fieldsError).some(field => fieldsError[field]);
}
  export default {
    components: { },
    props: {
        value: Boolean,
        show: {
            type:Boolean
        },
    },
    created () {
        //console.log(this.codMeal)
    },
    data() {
        return {
            loading: false,
            imageUrl: '',
            hasErrors,
            fileInfo:'',
            userInfo: localStorage.getItem('user'),
            userAvatar:'',

        }
    },
    methods: {

        useAvatar(){
        axios
            .post('tools/use/avatar',{ data: this.fileInfo})
            .then(this.fileInfo='',this.showDialogAvatar = false);
        },
        changeAvatar(){
            if(this.fileInfo){
                this.useAvatar();
            }
        },
        handleChange(info) {
        if (info.file.status === 'uploading') {
            this.loading = true;
            return;
        }
        if (info.file.status === 'done') {
            this.fileInfo=info.file.response;
            // Get this url from response in real world.
            getBase64(info.file.originFileObj, imageUrl => {
            this.imageUrl = imageUrl;
            this.loading = false;
            });
        }
        },
        beforeUpload(file) {
        const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
        if (!isJpgOrPng) {
            this.$message.error('You can only upload JPG file!');
        }
        const isLt2M = file.size / 1024 / 1024 < 10;
        if (!isLt2M) {
            this.$message.error('Image must smaller than 10MB!');
        }
        return isJpgOrPng && isLt2M;
        },
        handleConfirmBlur(e) {
        const value = e.target.value;
        this.confirmDirty = this.confirmDirty || !!value;
        },

        // Only show error after a field is touched.
        titleError() {
        const { getFieldError, isFieldTouched } = this.form;
        return isFieldTouched('title') && getFieldError('title');
        },
        summaryError() {
        const { getFieldError, isFieldTouched } = this.form;
        return isFieldTouched('summary') && getFieldError('summary');
        },
        experienceError() {
        const { getFieldError, isFieldTouched } = this.form;
        return isFieldTouched('experience') && getFieldError('experience');
        },
    },

    computed: {
        showDialogAvatar: {
        get () {
            return this.value
        },
        set (value) {
            this.$emit('input', value)
        }
        },
    },
    mounted() {
        const userData = JSON.parse(this.userInfo);
        this.userAvatar = userData.logged_in_user.avatar;
        this.imageUrl = 'storage/'+this.userAvatar;
      //console.log(this.codMeal)

    },
    watch: {
    showDialogAvatar (val, oldVal) {
      //console.log(val)
    }
    }

  }
</script>
<style>
.avatar-uploader > .ant-upload {
  width: 128px;
  height: 128px;
}
.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}

.picture_avatar {
  width: 128px;
  height: 128px;
}
</style>

