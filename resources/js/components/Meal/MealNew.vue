<template>

  <a-form  :form="form" @submit="handleSubmit" :label-col="{ span: 5 }" :wrapper-col="{ span: 18 }" >
  <a-row>
    <a-form-item label="PDF File">
        <a-upload
            name="file"
            action="/data_sync/public/api/fileOtherFormat"
            :before-upload="beforeUpload"
            @change="handleChange"
            :loading="loading"
            :multiple="false"
        >
            <a-button> <a-icon type="upload" /> Upload PDF </a-button>
        </a-upload>
    </a-form-item>

    <a-form-item label="Title" :validate-status="nameError() ? 'error' : ''" :help="nameError() || ''">
      <a-input
        v-decorator="[
          'name',
          { rules: [{ required: true, message: 'Please input a Title!' }] },
        ]"
        placeholder="Title"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Email">
      <a-input
        v-decorator="[
          'email',
          { rules: [
            {
            type: 'email',
            message: 'The input is not valid E-mail!',
            },

            { required: true, message: 'Please input email!' }
            ] },
        ]"
        placeholder="Email"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Web">
      <a-input
        v-decorator="[
          'web',
          { rules: [{ required: false, message: 'Please input web!' }] },
        ]"
        placeholder="Web"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Location" >
      <a-input
        v-decorator="[
          'location',
          { rules: [{ required: false, message: 'Please input location!' }] },
        ]"
        placeholder="Location"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Phone" >
      <a-input
        v-decorator="[
          'phone',
          { rules: [{ required: false, message: 'Please input phone!' }] },
        ]"
        placeholder="Phone"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Details" :validate-status="detailsError() ? 'error' : ''" :help="detailsError() || ''">
      <a-textarea
        placeholder="Details about your pub"
        :rows="2"
        v-decorator="[
          'details',
          { rules: [{ required: true, message: 'Please input details!' }] },
        ]"

        allow-clear

      />
    </a-form-item>


    <a-form-item label="Category" :validate-status="experienceError() ? 'error' : ''" :help="experienceError() || ''">
      <a-select
        v-decorator="[
          'experience',
          { rules: [{ required: true, message: 'Please input a Category!' }] },
        ]"
        placeholder="Select Category"
      >
        <a-select-option v-for="experience in experiences"  v-bind:value="experience.id" :key="experience.id" >
          ({{ experience.ref }}) {{ experience.title }} - {{ experience.description }}
        </a-select-option>
      </a-select>
    </a-form-item>

    <a-form-item label="Start/End Date" :validate-status="commonTimingError() ? 'error' : ''" :help="commonTimingError() || ''">
      <a-range-picker
      show-time
      format="YYYY-MM-DD HH:mm:ss"
        v-decorator="[
          'commonTiming',
          { rules: [{ required: true, message: 'Please input Start Date!' }] },
        ]"
      >

      </a-range-picker>
    </a-form-item>



    <a-form-item label="Options" :validate-status="optionsError() ? 'error' : ''" :help="optionsError() || ''" >
        <template>
          <a-select mode="tags" style="width: 100%" :token-separators="[',']" @change="handleOptChange"
          v-decorator="[
          'options',
              {
                rules: [{ required: false, message: 'Please input options!' }],
              },
            ]"
            >
            <a-select-option v-for="option in options" :key="option.name">
              {{ option.name }}
            </a-select-option>
          </a-select>
        </template>
    </a-form-item>

    <a-form-item label="Tags">
      <template v-for="tag in tags">
        <a-checkable-tag
          :key="tag.id"
          :checked="selectedTags.indexOf(tag.id) > -1"
          @change="checked => handletagChange(tag.id, checked)"
        >
          {{ tag.name }}
        </a-checkable-tag>
      </template>
    </a-form-item>

    <a-form-item >
      <a-col :xs="{ span: 24, offset: 0}" :lg="{ span: 20, offset: 7}">
          <a-button icon="check-circle"  type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())" >
              Save
          </a-button >
      </a-col>
    </a-form-item>
  </a-row>
  </a-form>
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
  data() {
    return {
      inputValue: 0,
      inputValue1: 1,
      loading: false,
      imageUrl: '',
      hasErrors,
      formLayout: 'horizontal',
      form: this.$form.createForm(this, { name: 'coordinated' }),
      experiences:'',
      fileInfo:'',
      userInfo: localStorage.getItem('user'),
      userID: '',
      chefeCV: '',
      commonTimings: '',
      currencys: '',
      tags: [],
      selectedTags: [],
      cuisines:null,
      ingredients:null,
      options:[],
      mealTypes:[],
    };
  },
  mounted() {
    this.$nextTick(() => {
      // To disabled submit button at the beginning.
      this.form.validateFields();
    });
  },
  methods: {
    reset() {
      this.$refs.formBooking.reset();
    },
    resetValidation() {
      this.$refs.formBooking.resetValidation();
    },
    filterOption(input, option) {
      return (
        option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      );
    },
    handleingreChange(value) {
      //console.log(`selected ${value}`);
    },
    handleOptChange(value) {
      //console.log(`selected ${value}`);
    },
    handletagChange(tag, checked) {
      const { selectedTags } = this;
      const nextSelectedTags = checked
        ? [...selectedTags, tag]
        : selectedTags.filter(t => t !== tag);
      //console.log('You are interested in: ', nextSelectedTags);
      this.selectedTags = nextSelectedTags;
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
      const isJpgOrPng = file.type === 'application/pdf' || file.type === 'application/pdf';
      if (!isJpgOrPng) {
        this.$message.error('You can only upload PDF file!');
      }
      const isLt2M = file.size / 1024 / 1024 < 20;
      if (!isLt2M) {
        this.$message.error('Image must smaller than 20MB!');
      }
      return isJpgOrPng && isLt2M;
    },
    handleConfirmBlur(e) {
      const value = e.target.value;
      this.confirmDirty = this.confirmDirty || !!value;
    },

    // Only show error after a field is touched.
    nameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('name') && getFieldError('name');
    },

    aliasError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('alias') && getFieldError('alias');
    },

    detailsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('details') && getFieldError('details');
    },
    experienceError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('experience') && getFieldError('experience');
    },
    timeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('time') && getFieldError('time');
    },
    peopleError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('people') && getFieldError('people');
    },
    mealTypeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('mealType') && getFieldError('mealType');
    },
    commonTimingError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('commonTiming') && getFieldError('commonTiming');
    },
    ingredientsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('ingredients') && getFieldError('ingredients');
    },
    optionsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('options') && getFieldError('options');
    },
    cuisineError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('cuisine') && getFieldError('cuisine');
    },
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          //console.log('Received values of form: ', values);
          this.sendData(values);
        }
      });
    },
  sendData(data) {
      axios
      .post("create/meal", { data: { mealData: data, tags:this.selectedTags, fileData:this.fileInfo} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

          } else {

              this.openNotification('success', 'Save', 'You have been store all data successfully');
              this.form.resetFields()
              //this.$router.push({ name: 'register/result' });
          }
      })
      .catch((error) => {
          this.success = false;
        var errors =null;
        var status=error.response.status;
        //console.log(status);
            if (status == 422){
            errors=error.response.data.errors;
            //console.log(errors);
            errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
          }else{
            this.openNotification('error','Error on Save',error);
          }
      });
  },
    openNotification: function (type, m, d) {
        this.$notification.config({
            placement: 'topRight',
            top: 35,
            duration: 8,
        });
        this.$notification[type]({
          message: m,
          description: d,
        });
    },
  },
  mounted() {
    const userData = JSON.parse(this.userInfo);
    this.userID = userData.logged_in_user.id;
  axios
      .get('getExperiences')
      .then(response => (this.experiences = response.data));
  axios
      .get('getCommonTiming')
      .then(response => (this.commonTimings = response.data));
  axios
      .get('getTimeCurrency')
      .then(response => (this.currencys = response.data));
  axios
      .get('getCuisines')
      .then(response => (this.cuisines = response.data));
  axios
      .get('getIngredients')
      .then(response => (this.ingredients = response.data));
  axios
      .get('getTags/2')
      .then(response => (this.tags = response.data));

  axios
      .get('getCVData/'+this.userID)
      .then(response => (this.chefeCV = response.data));
  axios
      .get('getOptions')
      .then(response => (this.options = response.data));
  axios
      .get('getMealType')
      .then(response => (this.mealTypes = response.data));
  },
};
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
  width: 200px;
  height: 200px;
}
.code-box-demo .ant-slider {
  margin-bottom: 16px;
}
</style>

